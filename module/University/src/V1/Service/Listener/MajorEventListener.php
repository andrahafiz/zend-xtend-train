<?php

namespace University\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use University\Mapper\MajorTrait as MajorMapperTrait;
use University\Entity\Major as MajorEntity;
use University\V1\MajorEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;

class MajorEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use MajorMapperTrait;

    protected $fileConfig;
    protected $majorEvent;
    protected $majorHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\Major $majorMapper
    ) {
        $this->setMajorMapper($majorMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MajorEvent::EVENT_CREATE_MAJOR,
            [$this, 'createMajor'],
            500
        );

        $this->listeners[] = $events->attach(
            MajorEvent::EVENT_DELETE_MAJOR,
            [$this, 'deleteMajor'],
            500
        );
    }

    public function createMajor(MajorEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();
            $bodyRequest['logo'] = $bodyRequest['logo']['tmp_name'];
            $bodyRequest = str_replace("data", "logo", $bodyRequest);

            $majorEntity = new MajorEntity;
            $hydrateEntity  = $this->getMajorHydrator()->hydrate($bodyRequest, $majorEntity);

            $entityResult   = $this->getMajorMapper()->save($hydrateEntity);
            $event->setMajorEntity($entityResult);
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

    public function deleteMajor(MajorEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getMajorMapper()->delete($deletedData);
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
     * Get the value of majorHydrator
     */
    public function getMajorHydrator()
    {
        return $this->majorHydrator;
    }

    /**
     * Set the value of majorHydrator
     *
     * @return  self
     */
    public function setMajorHydrator($majorHydrator)
    {
        $this->majorHydrator = $majorHydrator;

        return $this;
    }
}
