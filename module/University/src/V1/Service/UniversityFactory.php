<?php
namespace University\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UniversityFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $universityMapper = $container->get(\University\Mapper\University::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $universityService = new University($universityMapper, $accountMapper);
        // $universityService->setLogger($container->get("logger_default"));
        return $universityService;
    }
}
