<?php

namespace University\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class FacultyEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project'];
        $facultyMapper = $container->get(\University\Mapper\Faculty::class);
        $facultyHydrator = $container->get('HydratorManager')->get('University\Hydrator\Faculty');
        $facultyEventListener = new FacultyEventListener(
            $facultyMapper
        );
        $facultyEventListener->setLogger($container->get("logger_default"));
        $facultyEventListener->setFacultyHydrator($facultyHydrator);
        return $facultyEventListener;
    }
}
