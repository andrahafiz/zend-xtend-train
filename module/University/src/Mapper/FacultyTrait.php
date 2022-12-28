<?php

namespace University\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Faculty Trait
 */
trait FacultyTrait
{
    /**
     * @var \University\Mapper\Faculty
     */
    protected $facultyMapper;

    /**
     * Get the value of universityMapper
     *
     * @return  \University\Mapper\Faculty
     */
    public function getFacultyMapper()
    {
        return $this->universityMapper;
    }

    /**
     * Set the value of universityMapper
     *
     * @param  \University\Mapper\Faculty  $facultyMapper
     *
     * @return  self
     */
    public function setFacultyMapper(\University\Mapper\Faculty $facultyMapper)
    {
        $this->universityMapper = $facultyMapper;

        return $this;
    }
}
