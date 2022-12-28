<?php

namespace University\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class FacultyEvent extends Event
{
    const EVENT_CREATE_FACULTY           = 'create.faculty';
    const EVENT_CREATE_FACULTY_SUCCESS   = 'create.faculty.success';
    const EVENT_CREATE_FACULTY_ERROR     = 'create.faculty.error';

    const  EVENT_CREATE_MASS_FACULTY          = 'create.mass.faculty';
    const EVENT_CREATE_MASS_FACULTY_SUCCESS  = 'create.mass.faculty.success';
    const EVENT_CREATE_MASS_FACULTY_ERROR    = 'create.mass.faculty.error';
    /**
     * @var University\Entity\Faculty
     */

    protected $units;

    protected $facultyEntity;

    protected $facultyCollection;

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
     * Get the value of facultyEntity
     *
     * @return  University\Entity\Faculty
     */
    public function getFacultyEntity()
    {
        return $this->facultyEntity;
    }

    /**
     * Set the value of facultyEntity
     *
     * @param  University\Entity\Faculty  $facultyEntity
     *
     * @return  self
     */
    public function setFacultyEntity( \University\Entity\Faculty $facultyEntity)
    {
        $this->facultyEntity = $facultyEntity;

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
     * Get the value of facultyCollection
     */
    public function getFacultyCollection()
    {
        return $this->facultyCollection;
    }

    /**
     * Set the value of facultyCollection
     *
     * @return  self
     */
    public function setFacultyCollection(array $facultyCollection)
    {
        $this->facultyCollection = $facultyCollection;

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
