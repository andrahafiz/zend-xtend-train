<?php

namespace University\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use University\Mapper\RoomTrait as RoomMapperTrait;
use University\Entity\Room as RoomEntity;
use University\V1\RoomEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;

class RoomEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use RoomMapperTrait;

    protected $fileConfig;
    protected $roomEvent;
    protected $roomHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\Room $roomMapper
    ) {
        $this->setRoomMapper($roomMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_CREATE_ROOM,
            [$this, 'createRoom'],
            500
        );

        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_DELETE_ROOM,
            [$this, 'deleteRoom'],
            500
        );

        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_UPDATE_ROOM,
            [$this, 'updateRoom'],
            500
        );
    }

    public function createRoom(RoomEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
           

            $bodyRequest = $event->getInputFilter()->getValues();

            $roomEntity = new RoomEntity;
            $hydrateEntity  = $this->getRoomHydrator()->hydrate($bodyRequest, $roomEntity);

            $entityResult   = $this->getRoomMapper()->save($hydrateEntity);
            $event->setRoomEntity($entityResult);
        } catch (RuntimeException $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! \nError_message: {message}",
                [
                    "message" => $e->getMessage(),
                    "function" => __FUNCTION__
                ]
            );
            return $e;
        }
    }

    public function deleteRoom(RoomEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getRoomMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data room deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

      /**
     * Update Room
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateRoom(RoomEvent $event)
    {
        try {
            $roomEntity = $event->getRoomEntity();
            $roomEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();
            // $fileConfig = $this->getFileConfig()['room'];
            // $destinationFolder = $fileConfig['photo_dir'];
            // unset photo for now. Still stuck
            // unset($updateData['photo']);
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // test 1
            // adding filter for photo
            // $imgIcon = $event->getInputFilter()->get('photo')->getValue();
            // // var_dump($imgIcon);
            // if (isset($imgIcon)) {
            //     $inputPhoto  = $event->getInputFilter()->get('photo');
            //     $inputPhoto->getFilterChain()
            //     ->attach(new \Zend\Filter\File\RenameUpload([
            //         'target' => $destinationFolder,
            //         'use_upload_extension' => true,
            //         'overwrite' => true
            //         ]));
            //     $updateData['path']  = str_replace('data/', '', $imgIcon['tmp_name']);
            //     // var_dump($updateData['path']);
            //     $nameIconSmall = $updateData['path'];
            //     $event->getInputFilter()->get('photo')->setValue($nameIconSmall);
            // }

            // test 2
            // $roomPath = $roomEntity->getPath();
            // var_dump($roomPath);
            // $tmpName = $updateData['photo']['tmp_name'];
            // if ($tmpName != "") {
            //     $newPath = str_replace('data/', '', $tmpName);
            //     $roomPath = $newPath;
            //     var_dump($roomPath);
            // }

            $room = $this->getRoomHydrator()->hydrate($updateData, $roomEntity);

            // if using test 2
            // $room->setPath($roomPath);
            $this->getRoomMapper()->save($room);
            $uuid = $room->getUuid();
            $event->setRoomEntity($room);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Room data {uuid} updated successfully \n {data}",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $uuid,
                    "data" => json_encode($updateData),
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! \nError_message: {message}",
                [
                    "message" => $e->getMessage(),
                    "function" => __FUNCTION__
                ]
            );
            return $e;
        }
    }

    /**
     * Get the value of roomHydrator
     */
    public function getRoomHydrator()
    {
        return $this->roomHydrator;
    }

    /**
     * Set the value of roomHydrator
     *
     * @return  self
     */
    public function setRoomHydrator($roomHydrator)
    {
        $this->roomHydrator = $roomHydrator;

        return $this;
    }
}
