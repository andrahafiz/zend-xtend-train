<?php
namespace University\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use University\V1\MajorEvent;
use University\Entity\Major as MajorEntity;
use User\Mapper\AccountTrait as AccountMapperTrait;
use University\Mapper\MajorTrait as MajorMapperTrait;

class Major
{
    use EventManagerAwareTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use MajorMapperTrait;

    protected $majorEvent;

    /**
     * Constructor
     *
     * @param Major\Mapper\Major   $trackingMapper
     */
    public function __construct(
        \University\Mapper\Major $majorMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setMajorMapper($majorMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of majorEvent
     */
    public function getMajorEvent()
    {
        if ($this->majorEvent == null) {
            $this->majorEvent = new MajorEvent();
        }
        return $this->majorEvent;
    }

    /**
     * Set the value of majorEvent
     *
     * @return  selfinsert bulk gps log
     */
    public function setMajorEvent($majorEvent)
    {
        $this->majorEvent = $majorEvent;

        return $this;
    }

    public function createMajor($inputFilter)
    {
        $majorEvent = $this->getMajorEvent();
        $majorEvent->setInputFilter($inputFilter);

        $majorEvent->setName(MajorEvent::EVENT_CREATE_MAJOR);
        $create = $this->getEventManager()->triggerEvent($majorEvent);
        if ($create->stopped()) {
            $majorEvent->setName(MajorEvent::EVENT_CREATE_MAJOR_ERROR);
            $majorEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($majorEvent);
            throw $majorEvent->getException();
        } else {
            $majorEvent->setName(MajorEvent::EVENT_CREATE_MAJOR_SUCCESS);
            $this->getEventManager()->triggerEvent($majorEvent);
            return $majorEvent->getMajorEntity();
        }
    }

    public function delete(MajorEntity $deletedData)
    {
        $majorEvent = new MajorEvent();
        $majorEvent->setDeleteData($deletedData);
        $majorEvent->setName(MajorEvent::EVENT_DELETE_MAJOR);
        $create = $this->getEventManager()->triggerEvent($majorEvent);
        if ($create->stopped()) {
            $majorEvent->setName(MajorEvent::EVENT_DELETE_MAJOR_ERROR);
            $majorEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($majorEvent);
            throw $majorEvent->getException();
        } else {
            $majorEvent->setName(MajorEvent::EVENT_DELETE_MAJOR_SUCCESS);
            $this->getEventManager()->triggerEvent($majorEvent);
            return true;
        }
    }


    public function createMassMajor($account, $units)
    {
        $majorEvent = $this->getMajorEvent();
        $majorEvent->setUserProfile($account);
        $majorEvent->setUnits($units);
        $majorEvent->setName(MajorEvent::EVENT_CREATE_MASS_MAJOR);
        $create = $this->getEventManager()->triggerEvent($majorEvent);
        if ($create->stopped()) {
            $majorEvent->setName(MajorEvent::EVENT_CREATE_MASS_MAJOR_ERROR);
            $majorEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($majorEvent);
            throw $majorEvent->getException();
        } else {
            $majorEvent->setName(MajorEvent::EVENT_CREATE_MASS_MAJOR_SUCCESS);
            $this->getEventManager()->triggerEvent($majorEvent);
            return $majorEvent->getMajorCollection();
        }
    }
}
