<?php

namespace University\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Major Trait
 */
trait MajorTrait
{
    /**
     * @var \University\Mapper\Major
     */
    protected $majorMapper;

    /**
     * Get the value of majorMapper
     *
     * @return  \University\Mapper\Major
     */
    public function getMajorMapper()
    {
        return $this->majorMapper;
    }

    /**
     * Set the value of majorMapper
     *
     * @param  \University\Mapper\Major  $majorMapper
     *
     * @return  self
     */
    public function setMajorMapper(\University\Mapper\Major $majorMapper)
    {
        $this->majorMapper = $majorMapper;

        return $this;
    }
}
