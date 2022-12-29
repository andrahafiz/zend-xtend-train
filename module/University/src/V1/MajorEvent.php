<?php

namespace University\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class MajorEvent extends Event
{
    const EVENT_CREATE_MAJOR           = 'create.major';
    const EVENT_CREATE_MAJOR_SUCCESS   = 'create.major.success';
    const EVENT_CREATE_MAJOR_ERROR     = 'create.major.error';

    const  EVENT_CREATE_MASS_MAJOR          = 'create.mass.major';
    const EVENT_CREATE_MASS_MAJOR_SUCCESS  = 'create.mass.major.success';
    const EVENT_CREATE_MASS_MAJOR_ERROR    = 'create.mass.major.error';

    const EVENT_DELETE_MAJOR         = 'delete.major';
    const EVENT_DELETE_MAJOR_ERROR   = 'delete.major.error';
    const EVENT_DELETE_MAJOR_SUCCESS = 'delete.major.success';

    /**
     * @var University\Entity\Major
     */

    protected $units;

    protected $majorEntity;

    protected $majorCollection;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $userProfile;

    protected $deleteData;
    /**
     * @var string
     */

    protected $bodyResponse;

    /**
     * Get the value of majorEntity
     *
     * @return  University\Entity\Major
     */
    public function getMajorEntity()
    {
        return $this->majorEntity;
    }

    /**
     * Set the value of majorEntity
     *
     * @param  University\Entity\Major  $majorEntity
     *
     * @return  self
     */
    public function setMajorEntity(\University\Entity\Major $majorEntity)
    {
        $this->majorEntity = $majorEntity;

        return $this;
    }


    /**
     * Get the value of deleteData
     */
    public function getDeleteData()
    {
        return $this->deleteData;
    }

    /**
     * Set the value of deleteData
     *
     * @return  self
     */
    public function setDeleteData($deleteData)
    {
        $this->deleteData = $deleteData;

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
     * Get the value of majorCollection
     */
    public function getMajorCollection()
    {
        return $this->majorCollection;
    }

    /**
     * Set the value of majorCollection
     *
     * @return  self
     */
    public function setMajorCollection(array $majorCollection)
    {
        $this->majorCollection = $majorCollection;

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
