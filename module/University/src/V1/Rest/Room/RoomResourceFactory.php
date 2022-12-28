<?php
namespace University\V1\Rest\Room;

class RoomResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $roomMapper   = $services->get(\University\Mapper\Room::class);
        $roomService  = $services->get(\University\V1\Service\Room::class);
        $roomResource = new RoomResource(
            $userProfileMapper,
            $roomMapper, 
        );
        $roomResource->setRoomService($roomService);
        return $roomResource;
    }
}
