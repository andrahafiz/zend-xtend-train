<?php

namespace Lectures\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Schedule
 */
class Schedule implements EntityInterface
{
    /**
     * @var \DateTime|null
     */
    private $starttime;

    /**
     * @var \DateTime|null
     */
    private $endtime;

    /**
     * @var string|null
     */
    private $topic;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\UserProfile
     */
    private $ledBy;

    /**
     * @var \Univesity\Entity\Room
     */
    private $room;


    /**
     * Set starttime.
     *
     * @param \DateTime|null $starttime
     *
     * @return Schedule
     */
    public function setStarttime($starttime = null)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime.
     *
     * @return \DateTime|null
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime.
     *
     * @param \DateTime|null $endtime
     *
     * @return Schedule
     */
    public function setEndtime($endtime = null)
    {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime.
     *
     * @return \DateTime|null
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set topic.
     *
     * @param string|null $topic
     *
     * @return Schedule
     */
    public function setTopic($topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic.
     *
     * @return string|null
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Schedule
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Schedule
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Schedule
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return Schedule
     */
    public function setDeletedAt($deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set ledBy.
     *
     * @param \User\Entity\UserProfile|null $ledBy
     *
     * @return Schedule
     */
    public function setLedBy(\User\Entity\UserProfile $ledBy = null)
    {
        $this->ledBy = $ledBy;

        return $this;
    }

    /**
     * Get ledBy.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getLedBy()
    {
        return $this->ledBy;
    }

    /**
     * Set room.
     *
     * @param \Univesity\Entity\Room|null $room
     *
     * @return Schedule
     */
    public function setRoom(\Univesity\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room.
     *
     * @return \Univesity\Entity\Room|null
     */
    public function getRoom()
    {
        return $this->room;
    }
}
