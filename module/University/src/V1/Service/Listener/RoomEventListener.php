<?php

namespace University\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use University\Mapper\RoomTrait as RoomMapperTrait;
use University\Entity\Room as RoomEntity;
use University\V1\RoomEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;

class RoomEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use RoomMapperTrait;

    protected $fileConfig;
    protected $roomEvent;
    protected $roomHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\Room $roomMapper
    ) {
        $this->setRoomMapper($roomMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_CREATE_ROOM,
            [$this, 'createRoom'],
            500
        );
    }

    public function createRoom(RoomEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
           

            $bodyRequest = $event->getInputFilter()->getValues();

            $roomEntity = new RoomEntity;
            $hydrateEntity  = $this->getRoomHydrator()->hydrate($bodyRequest, $roomEntity);

            $entityResult   = $this->getRoomMapper()->save($hydrateEntity);
            $event->setRoomEntity($entityResult);
        } catch (RuntimeException $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! \nError_message: {message}",
                [
                    "message" => $e->getMessage(),
                    "function" => __FUNCTION__
                ]
            );
            return $e;
        }
    }

    /**
     * Get the value of roomHydrator
     */
    public function getRoomHydrator()
    {
        return $this->roomHydrator;
    }

    /**
     * Set the value of roomHydrator
     *
     * @return  self
     */
    public function setRoomHydrator($roomHydrator)
    {
        $this->roomHydrator = $roomHydrator;

        return $this;
    }
}
