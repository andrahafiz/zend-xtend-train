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
     * Get the value of facultyMapper
     *
     * @return  \University\Mapper\Faculty
     */
    public function getFacultyMapper()
    {
        return $this->facultyMapper;
    }

    /**
     * Set the value of facultyMapper
     *
     * @param  \University\Mapper\Faculty  $facultyMapper
     *
     * @return  self
     */
    public function setFacultyMapper(\University\Mapper\Faculty $facultyMapper)
    {
        $this->facultyMapper = $facultyMapper;

        return $this;
    }
}
