<?php

namespace University\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UniversityEvent extends Event
{
    const EVENT_CREATE_UNIVERSITY           = 'create.university';
    const EVENT_CREATE_UNIVERSITY_SUCCESS   = 'create.university.success';
    const EVENT_CREATE_UNIVERSITY_ERROR     = 'create.university.error';

    const EVENT_CREATE_MASS_UNIVERSITY          = 'create.mass.university';
    const EVENT_CREATE_MASS_UNIVERSITY_SUCCESS  = 'create.mass.university.success';
    const EVENT_CREATE_MASS_UNIVERSITY_ERROR    = 'create.mass.university.error';
    /**
     * @var University\Entity\University
     */

    protected $units;

    protected $universityEntity;

    protected $universityCollection;

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
     * Get the value of universityEntity
     *
     * @return  University\Entity\University
     */
    public function getUniversityEntity()
    {
        return $this->universityEntity;
    }

    /**
     * Set the value of universityEntity
     *
     * @param  University\Entity\University  $universityEntity
     *
     * @return  self
     */
    public function setUniversityEntity(\University\Entity\University $universityEntity)
    {
        $this->universityEntity = $universityEntity;

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
     * Get the value of universityCollection
     */
    public function getUniversityCollection()
    {
        return $this->universityCollection;
    }

    /**
     * Set the value of universityCollection
     *
     * @return  self
     */
    public function setUniversityCollection(array $universityCollection)
    {
        $this->universityCollection = $universityCollection;

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
