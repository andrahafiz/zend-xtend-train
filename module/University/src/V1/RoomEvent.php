<?php

namespace University\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class RoomEvent extends Event
{
    const EVENT_CREATE_ROOM           = 'create.room';
    const EVENT_CREATE_ROOM_SUCCESS   = 'create.room.success';
    const EVENT_CREATE_ROOM_ERROR     = 'create.room.error';

    const  EVENT_CREATE_MASS_ROOM          = 'create.mass.room';
    const EVENT_CREATE_MASS_ROOM_SUCCESS  = 'create.mass.room.success';
    const EVENT_CREATE_MASS_ROOM_ERROR    = 'create.mass.room.error';
    /**
     * @var University\Entity\Room
     */

    protected $units;

    protected $roomEntity;

    protected $roomCollection;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $userProfile;

    /**
     * @var string
     */

    protected $bodyResponse;

    /**
     * Get the value of roomEntity
     *
     * @return  University\Entity\Room
     */
    public function getRoomEntity()
    {
        return $this->roomEntity;
    }

    /**
     * Set the value of roomEntity
     *
     * @param  University\Entity\Room  $roomEntity
     *
     * @return  self
     */
    public function setRoomEntity( \University\Entity\Room $roomEntity)
    {
        $this->roomEntity = $roomEntity;

        return $this;
    }

    /**
     * Get the value of inputFilter
     *
     * @return  Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * Set the value of inputFilter
     *
     * @param  Zend\InputFilter\InputFilterInterface  $inputFilter
     *
     * @return  self
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * Get the value of exception
     *
     * @return  \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set the value of exception
     *
     * @param  \Exception  $exception
     *
     * @return  self
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get the value of userProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @return  self
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get the value of roomCollection
     */
    public function getRoomCollection()
    {
        return $this->roomCollection;
    }

    /**
     * Set the value of roomCollection
     *
     * @return  self
     */
    public function setRoomCollection(array $roomCollection)
    {
        $this->roomCollection = $roomCollection;

        return $this;
    }
    /**
     * Get the value of companyEntity
     *
     * @return  User\Entity\Company
     */
    public function getCompanyEntity()
    {
        return $this->companyEntity;
    }

    /**
     * Set the value of companyEntity
     *
     * @param  User\Entity\Company  $companyEntity
     *
     * @return  self
     */
    public function setCompanyEntity(\User\Entity\Company $companyEntity)
    {
        $this->companyEntity = $companyEntity;

        return $this;
    }
    /**
     * Get the value of units
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Set the value of units
     *
     * @return  self
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }
}
