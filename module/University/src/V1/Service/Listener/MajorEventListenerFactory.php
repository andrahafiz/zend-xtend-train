<?php

namespace University\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MajorEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project'];
        $majorMapper = $container->get(\University\Mapper\Major::class);
        $majorHydrator = $container->get('HydratorManager')->get('University\Hydrator\Major');
        $majorEventListener = new MajorEventListener(
            $majorMapper
        );
        $majorEventListener->setLogger($container->get("logger_default"));
        $majorEventListener->setMajorHydrator($majorHydrator);
        return $majorEventListener;
    }
}
