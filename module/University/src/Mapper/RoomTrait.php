<?php

namespace University\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Room Trait
 */
trait RoomTrait
{
    /**
     * @var \University\Mapper\Room
     */
    protected $roomMapper;

    /**
     * Get the value of roomMapper
     *
     * @return  \University\Mapper\Room
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * Set the value of roomMapper
     *
     * @param  \University\Mapper\Room  $roomMapper
     *
     * @return  self
     */
    public function setRoomMapper(\University\Mapper\Room $roomMapper)
    {
        $this->roomMapper = $roomMapper;

        return $this;
    }
}
