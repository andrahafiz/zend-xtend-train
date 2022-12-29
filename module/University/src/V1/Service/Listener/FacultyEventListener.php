<?php

namespace University\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use University\Mapper\FacultyTrait as FacultyMapperTrait;
use University\Entity\Faculty as FacultyEntity;
use University\V1\FacultyEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;

class FacultyEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use FacultyMapperTrait;

    protected $fileConfig;
    protected $facultyEvent;
    protected $facultyHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\Faculty $facultyMapper
    ) {
        $this->setFacultyMapper($facultyMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            FacultyEvent::EVENT_CREATE_FACULTY,
            [$this, 'createFaculty'],
            500
        );

        $this->listeners[] = $events->attach(
            FacultyEvent::EVENT_DELETE_FACULTY,
            [$this, 'deleteFaculty'],
            500
        );

        $this->listeners[] = $events->attach(
            FacultyEvent::EVENT_UPDATE_FACULTY,
            [$this, 'updateFaculty'],
            500
        );
    }

    public function createFaculty(FacultyEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();
            $bodyRequest['logo'] = $bodyRequest['logo']['tmp_name'];
            $bodyRequest = str_replace("data", "logo", $bodyRequest);

            $facultyEntity = new FacultyEntity;
            $hydrateEntity  = $this->getFacultyHydrator()->hydrate($bodyRequest, $facultyEntity);

            $entityResult   = $this->getFacultyMapper()->save($hydrateEntity);
            $event->setFacultyEntity($entityResult);
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

    public function deleteFaculty(FacultyEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getFacultyMapper()->delete($deletedData);
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
     * Update Faculty
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateFaculty(FacultyEvent $event)
    {
        try {
           $facultyEntity = $event->getFacultyEntity();
           $facultyEntity->setUpdatedAt(new \DateTime('now'));
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
            //$facultyPath =$facultyEntity->getPath();
            // var_dump($facultyPath);
            // $tmpName = $updateData['photo']['tmp_name'];
            // if ($tmpName != "") {
            //     $newPath = str_replace('data/', '', $tmpName);
            //    $facultyPath = $newPath;
            //     var_dump($facultyPath);
            // }

           $faculty = $this->getFacultyHydrator()->hydrate($updateData,$facultyEntity);

            // if using test 2
            //$faculty->setPath($facultyPath);
            $this->getFacultyMapper()->save($faculty);
            $uuid =$faculty->getUuid();
            $event->setFacultyEntity($faculty);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Faculty data {uuid} updated successfully \n {data}",
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
     * Get the value of facultyHydrator
     */
    public function getFacultyHydrator()
    {
        return $this->facultyHydrator;
    }

    /**
     * Set the value of facultyHydrator
     *
     * @return  self
     */
    public function setFacultyHydrator($facultyHydrator)
    {
        $this->facultyHydrator = $facultyHydrator;

        return $this;
    }
}
