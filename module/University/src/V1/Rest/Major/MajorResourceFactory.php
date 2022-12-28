<?php
namespace University\V1\Rest\Major;

class MajorResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $majorMapper   = $services->get(\University\Mapper\Major::class);
        $majorService  = $services->get(\University\V1\Service\Major::class);
        $majorResource = new MajorResource(
            $userProfileMapper,
            $majorMapper, 
        );
        $majorResource->setMajorService($majorService);
        return $majorResource;
    }
}
