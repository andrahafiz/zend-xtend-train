<?php
namespace University\V1\Service;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use University\Entity\Room as RoomEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use University\V1\RoomEvent;

class Room
{
    use EventManagerAwareTrait;

    protected $roomEvent;


    public function create($inputFilter)
    {
        $roomEvent = new RoomEvent();
        $roomEvent->setInputFilter($inputFilter);
        $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM);
        $create = $this->getEventManager()->triggerEvent($roomEvent);
        if ($create->stopped()) {
            $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM_ERROR);
            $roomEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
            return $roomEvent->getRoomEntity();
        }
    }

    public function delete(RoomEntity $deletedData)
    {
        $roomEvent = new RoomEvent();
        $roomEvent->setDeleteData($deletedData);
        $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM);
        $create = $this->getEventManager()->triggerEvent($roomEvent);
        if ($create->stopped()) {
            $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM_ERROR);
            $roomEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
            return true;
        }
    }

    public function getRoomEvent()
    {
        if ($this->roomEvent == null) {
            $this->roomEvent = new RoomEvent();
        }

        return $this->roomEvent;
    }

    public function setRoomEvent(RoomEvent $roomEvent)
    {
        $this->roomEvent = $roomEvent;
    }
}
