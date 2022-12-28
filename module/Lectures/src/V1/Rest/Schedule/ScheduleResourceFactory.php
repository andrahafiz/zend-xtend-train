<?php
namespace Lectures\V1\Rest\Schedule;

class ScheduleResourceFactory
{
    public function __invoke($services)
    {
        return new ScheduleResource();
    }
}
