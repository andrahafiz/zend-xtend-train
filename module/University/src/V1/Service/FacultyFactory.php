<?php
namespace University\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class FacultyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $facultyMapper = $container->get(\University\Mapper\Faculty::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $facultyService = new University($facultyMapper, $accountMapper);
        // $facultyService->setLogger($container->get("logger_default"));
        return $facultyService;
    }
}
