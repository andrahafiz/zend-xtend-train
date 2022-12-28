<?php
namespace University\V1\Rest\Faculty;

class FacultyResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $facultyMapper   = $services->get(\University\Mapper\Faculty::class);
        $facultyService  = $services->get(\University\V1\Service\Faculty::class);
        $facultyResource = new FacultyResource(
            $userProfileMapper,
            $facultyMapper, 
        );
        $facultyResource->setFacultyService($facultyService);
        return $facultyResource;
    }
}
