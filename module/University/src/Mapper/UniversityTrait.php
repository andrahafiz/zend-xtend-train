<?php

namespace University\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * University Trait
 */
trait UniversityTrait
{
    /**
     * @var \University\Mapper\University
     */
    protected $universityMapper;

    /**
     * Get the value of universityMapper
     *
     * @return  \University\Mapper\University
     */
    public function getUniversityMapper()
    {
        return $this->universityMapper;
    }

    /**
     * Set the value of universityMapper
     *
     * @param  \University\Mapper\University  $universityMapper
     *
     * @return  self
     */
    public function setUniversityMapper(\University\Mapper\University $universityMapper)
    {
        $this->universityMapper = $universityMapper;

        return $this;
    }
}
