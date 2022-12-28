<?php
namespace User\V1\Rest\Room;

class RoomResourceFactory
{
    public function __invoke($services)
    {
        return new RoomResource();
    }
}
