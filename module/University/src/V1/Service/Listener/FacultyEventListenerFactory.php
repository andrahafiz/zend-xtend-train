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
    protected $universityEvent;
    protected $universityHydrator;
    protected $branchHydrator;
    protected $departmentHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \University\Mapper\Faculty $universityMapper
    ) {
        $this->setFacultyMapper($universityMapper);
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

            $universityEntity = new FacultyEntity;
            $hydrateEntity  = $this->getFacultyHydrator()->hydrate($bodyRequest, $universityEntity);

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

    /**
     * Get the value of universityHydrator
     */
    public function getFacultyHydrator()
    {
        return $this->universityHydrator;
    }

    /**
     * Set the value of universityHydrator
     *
     * @return  self
     */
    public function setFacultyHydrator($universityHydrator)
    {
        $this->universityHydrator = $universityHydrator;

        return $this;
    }
}
