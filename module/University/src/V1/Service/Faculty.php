<?php
namespace University\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use University\V1\FacultyEvent;
use User\Mapper\AccountTrait as AccountMapperTrait;
use University\Mapper\FacultyTrait as FacultyMapperTrait;

class Faculty
{
    use EventManagerAwareTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use FacultyMapperTrait;

    protected $universityEvent;

    /**
     * Constructor
     *
     * @param University\Mapper\Faculty   $trackingMapper
     */
    public function __construct(
        \University\Mapper\Faculty $universityMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setFacultyMapper($universityMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of universityEvent
     */
    public function getFacultyEvent()
    {
        if ($this->universityEvent == null) {
            $this->universityEvent = new FacultyEvent();
        }
        return $this->universityEvent;
    }

    /**
     * Set the value of universityEvent
     *
     * @return  selfinsert bulk gps log
     */
    public function setFacultyEvent($universityEvent)
    {
        $this->universityEvent = $universityEvent;

        return $this;
    }

    public function createFaculty($inputFilter)
    {
        $universityEvent = $this->getFacultyEvent();
        $universityEvent->setInputFilter($inputFilter);

        $universityEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY);
        $create = $this->getEventManager()->triggerEvent($universityEvent);
        if ($create->stopped()) {
            $universityEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY_ERROR);
            $universityEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
            return $universityEvent->getFacultyEntity();
        }
    }


    public function createMassFaculty($account, $units)
    {
        $universityEvent = $this->getFacultyEvent();
        $universityEvent->setUserProfile($account);
        $universityEvent->setUnits($units);
        $universityEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY);
        $create = $this->getEventManager()->triggerEvent($universityEvent);
        if ($create->stopped()) {
            $universityEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY_ERROR);
            $universityEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
            return $universityEvent->getFacultyCollection();
        }
    }
}
