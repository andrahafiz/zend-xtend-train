<?php

namespace University\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use University\Mapper\UniversityTrait as UniversityMapperTrait;
use University\Entity\University as UniversityEntity;
use University\V1\UniversityEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;

class UniversityEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UniversityMapperTrait;

    protected $fileConfig;
    protected $universityEvent;
    protected $universityHydrator;
    protected $branchHydrator;
    protected $departmentHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\University $universityMapper
    ) {
        $this->setUniversityMapper($universityMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UniversityEvent::EVENT_CREATE_UNIVERSITY,
            [$this, 'createUniversity'],
            500
        );

        $this->listeners[] = $events->attach(
            UniversityEvent::EVENT_DELETE_UNIVERSITY,
            [$this, 'deleteUniversity'],
            500
        );

        $this->listeners[] = $events->attach(
            UniversityEvent::EVENT_UPDATE_UNIVERSITY,
            [$this, 'updateUniversity'],
            500
        );
    }

    public function createUniversity(UniversityEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();
            $bodyRequest['logo'] = $bodyRequest['logo']['tmp_name'];
            $bodyRequest = str_replace("data", "logo", $bodyRequest);

            $universityEntity = new UniversityEntity;
            $hydrateEntity  = $this->getUniversityHydrator()->hydrate($bodyRequest, $universityEntity);

            $entityResult   = $this->getUniversityMapper()->save($hydrateEntity);
            $event->setUniversityEntity($entityResult);
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


    public function deleteUniversity(UniversityEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getUniversityMapper()->delete($deletedData);
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
     * Update University
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateUniversity(UniversityEvent $event)
    {
        try {
            $universityEntity = $event->getUniversityEntity();
            $universityEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();
            $fileConfig = $this->getFileConfig()['university'];
            $destinationFolder = $fileConfig['photo_dir'];
         
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
            $universityPath = $universityEntity->getLogo();
            // var_dump("TEST" . $updateData['logo']['tmp_name']);
            // var_dump("TEST" . $updateData['logo']['tmp_name']);
            $tmpName = $updateData['logo']['tmp_name'];
            unlink('data/'. $universityPath);
            var_dump($universityPath);
            var_dump($tmpName);
            // exit;
            // unlink($tmpName);
            if ($tmpName != "") {
                // unlink();
                $newPath = str_replace('data/', '', $tmpName);
                $universityPath = $newPath;
                // var_dump($universityPath);
            }
            

            $university = $this->getUniversityHydrator()->hydrate($updateData, $universityEntity);

            // if using test 2
            $university->setLogo($universityPath);
            $this->getUniversityMapper()->save($university);
            $uuid = $university->getUuid();
            $event->setUniversityEntity($university);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: University data {uuid} updated successfully \n {data}",
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
     * Get the value of fileConfig
     */
    public function getFileConfig()
    {
        return $this->fileConfig;
    }

    /**
     * Set the value of fileConfig
     *
     * @return  self
     */
    public function setFileConfig($fileConfig)
    {
        $this->fileConfig = $fileConfig;

        return $this;
    }

    /**
     * Get the value of universityHydrator
     */
    public function getUniversityHydrator()
    {
        return $this->universityHydrator;
    }

    /**
     * Set the value of universityHydrator
     *
     * @return  self
     */
    public function setUniversityHydrator($universityHydrator)
    {
        $this->universityHydrator = $universityHydrator;

        return $this;
    }
}
