<?php

namespace Lectures\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Schedule Trait
 */
trait ScheduleTrait
{
    /**
     * @var \Schedule\Mapper\Schedule
     */
    protected $scheduleMapper;

    /**
     * Get the value of scheduleMapper
     *
     * @return  \Schedule\Mapper\Schedule
     */
    public function getScheduleMapper()
    {
        return $this->scheduleMapper;
    }

    /**
     * Set the value of scheduleMapper
     *
     * @param  \Schedule\Mapper\Schedule  $scheduleMapper
     *
     * @return  self
     */
    public function setScheduleMapper(\Lectures\Mapper\Schedule $scheduleMapper)
    {
        $this->scheduleMapper = $scheduleMapper;

        return $this;
    }
}
