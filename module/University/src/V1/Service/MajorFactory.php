<?php
namespace University\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MajorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $majorMapper = $container->get(\University\Mapper\Major::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $majorService = new Major($majorMapper, $accountMapper);
        // $majorService->setLogger($container->get("logger_default"));
        return $majorService;
    }
}
