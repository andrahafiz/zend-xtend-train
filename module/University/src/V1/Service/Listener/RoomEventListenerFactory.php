<?php
namespace University\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoomEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomMapper = $container->get(\University\Mapper\Room::class);
        $roomHydrator = $container->get('HydratorManager')->get('University\Hydrator\Room');
        $roomEventListener = new RoomEventListener(
            $roomMapper
        );
        $roomEventListener->setLogger($container->get("logger_default"));
        $roomEventListener->setRoomHydrator($roomHydrator);
        return $roomEventListener;
    }
}
