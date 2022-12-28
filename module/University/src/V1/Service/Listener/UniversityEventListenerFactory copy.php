<?php

namespace University\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UniversityEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project'];
        $universityMapper = $container->get(\University\Mapper\University::class);
        $universityHydrator = $container->get('HydratorManager')->get('University\Hydrator\University');
        $universityEventListener = new FacultyEventListener(
            $universityMapper
        );
        $universityEventListener->setLogger($container->get("logger_default"));
        $universityEventListener->setFacultyHydrator($universityHydrator);
        return $universityEventListener;
    }
}
