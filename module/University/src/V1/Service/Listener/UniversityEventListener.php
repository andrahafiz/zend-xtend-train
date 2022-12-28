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
