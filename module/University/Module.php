<?php
namespace University;

use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $sm = $mvcEvent->getApplication()->getServiceManager();

        // university
        $universityService = $sm->get(\University\V1\Service\University::class);
        $universityEventListener = $sm->get(\University\V1\Service\Listener\UniversityEventListener::class);
        $universityEventListener->attach($universityService->getEventManager());

         // faculty
        $facultyService = $sm->get(\University\V1\Service\Faculty::class);
        $facultyEventListener = $sm->get(\University\V1\Service\Listener\FacultyEventListener::class);
        $facultyEventListener->attach($facultyService->getEventManager());

        // faculty
        $majorService = $sm->get(\University\V1\Service\Major::class);
        $majorEventListener = $sm->get(\University\V1\Service\Listener\MajorEventListener::class);
        $majorEventListener->attach($majorService->getEventManager());

    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
