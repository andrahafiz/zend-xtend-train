<?php
namespace University\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use University\V1\UniversityEvent;
use University\Entity\University as UniversityEntity;
use User\Mapper\AccountTrait as AccountMapperTrait;
use University\Mapper\UniversityTrait as UniversityMapperTrait;

class University
{
    use EventManagerAwareTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use UniversityMapperTrait;

    protected $universityEvent;

    /**
     * Constructor
     *
     * @param University\Mapper\University   $trackingMapper
     */
    public function __construct(
        \University\Mapper\University $universityMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setUniversityMapper($universityMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of universityEvent
     */
    public function getUniversityEvent()
    {
        if ($this->universityEvent == null) {
            $this->universityEvent = new UniversityEvent();
        }
        return $this->universityEvent;
    }

    /**
     * Set the value of universityEvent
     *
     * @return  selfinsert bulk gps log
     */
    public function setUniversityEvent($universityEvent)
    {
        $this->universityEvent = $universityEvent;

        return $this;
    }

    public function createUniversity($inputFilter)
    {
        $universityEvent = $this->getUniversityEvent();
        $universityEvent->setInputFilter($inputFilter);

        $universityEvent->setName(UniversityEvent::EVENT_CREATE_UNIVERSITY);
        $create = $this->getEventManager()->triggerEvent($universityEvent);
        if ($create->stopped()) {
            $universityEvent->setName(UniversityEvent::EVENT_CREATE_UNIVERSITY_ERROR);
            $universityEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(UniversityEvent::EVENT_CREATE_UNIVERSITY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
            return $universityEvent->getUniversityEntity();
        }
    }

      /**
     * Update University
     *
     * @param \University\Entity\University  $university
     * @param array                     $updateData
     */
    public function update($university, $inputFilter)
    {
        $universityEvent = $this->getUniversityEvent();
        $universityEvent->setUniversityEntity($university);

        $universityEvent->setUpdateData($inputFilter->getValues());
        $universityEvent->setInputFilter($inputFilter);
        $universityEvent->setName(UniversityEvent::EVENT_UPDATE_UNIVERSITY);

        $update = $this->getEventManager()->triggerEvent($universityEvent);
        if ($update->stopped()) {
            $universityEvent->setName(UniversityEvent::EVENT_UPDATE_UNIVERSITY_ERROR);
            $universityEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(UniversityEvent::EVENT_UPDATE_UNIVERSITY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
        }
    }

    public function delete(UniversityEntity $deletedData)
    {
        $universityEvent = new UniversityEvent();
        $universityEvent->setDeleteData($deletedData);
        $universityEvent->setName(UniversityEvent::EVENT_DELETE_UNIVERSITY);
        $create = $this->getEventManager()->triggerEvent($universityEvent);
        if ($create->stopped()) {
            $universityEvent->setName(UniversityEvent::EVENT_DELETE_UNIVERSITY_ERROR);
            $universityEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(UniversityEvent::EVENT_DELETE_UNIVERSITY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
            return true;
        }
    }

    public function createMassUniversity($account, $units)
    {
        $universityEvent = $this->getUniversityEvent();
        $universityEvent->setUserProfile($account);
        $universityEvent->setUnits($units);
        $universityEvent->setName(UniversityEvent::EVENT_CREATE_MASS_UNIVERSITY);
        $create = $this->getEventManager()->triggerEvent($universityEvent);
        if ($create->stopped()) {
            $universityEvent->setName(UniversityEvent::EVENT_CREATE_MASS_UNIVERSITY_ERROR);
            $universityEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($universityEvent);
            throw $universityEvent->getException();
        } else {
            $universityEvent->setName(UniversityEvent::EVENT_CREATE_MASS_UNIVERSITY_SUCCESS);
            $this->getEventManager()->triggerEvent($universityEvent);
            return $universityEvent->getUniversityCollection();
        }
    }
}
