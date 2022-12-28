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

    protected $facultyEvent;

    /**
     * Constructor
     *
     * @param Faculty\Mapper\Faculty   $trackingMapper
     */
    public function __construct(
        \University\Mapper\Faculty $facultyMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setFacultyMapper($facultyMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of facultyEvent
     */
    public function getFacultyEvent()
    {
        if ($this->facultyEvent == null) {
            $this->facultyEvent = new FacultyEvent();
        }
        return $this->facultyEvent;
    }

    /**
     * Set the value of facultyEvent
     *
     * @return  selfinsert bulk gps log
     */
    public function setFacultyEvent($facultyEvent)
    {
        $this->facultyEvent = $facultyEvent;

        return $this;
    }

    public function createFaculty($inputFilter)
    {
        $facultyEvent = $this->getFacultyEvent();
        $facultyEvent->setInputFilter($inputFilter);

        $facultyEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY);
        $create = $this->getEventManager()->triggerEvent($facultyEvent);
        if ($create->stopped()) {
            $facultyEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY_ERROR);
            $facultyEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($facultyEvent);
            throw $facultyEvent->getException();
        } else {
            $facultyEvent->setName(FacultyEvent::EVENT_CREATE_FACULTY_SUCCESS);
            $this->getEventManager()->triggerEvent($facultyEvent);
            return $facultyEvent->getFacultyEntity();
        }
    }


    public function createMassFaculty($account, $units)
    {
        $facultyEvent = $this->getFacultyEvent();
        $facultyEvent->setUserProfile($account);
        $facultyEvent->setUnits($units);
        $facultyEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY);
        $create = $this->getEventManager()->triggerEvent($facultyEvent);
        if ($create->stopped()) {
            $facultyEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY_ERROR);
            $facultyEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($facultyEvent);
            throw $facultyEvent->getException();
        } else {
            $facultyEvent->setName(FacultyEvent::EVENT_CREATE_MASS_FACULTY_SUCCESS);
            $this->getEventManager()->triggerEvent($facultyEvent);
            return $facultyEvent->getFacultyCollection();
        }
    }
}
