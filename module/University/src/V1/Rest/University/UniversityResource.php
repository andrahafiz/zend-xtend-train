<?php

namespace University\V1\Rest\University;

use Exception;
use University\Mapper\UniversityTrait;
use User\Mapper\UserAclTrait;
use User\Mapper\UserProfileTrait;
use User\V1\Rest\AbstractResource;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class UniversityResource extends AbstractResource
{
    use UserProfileTrait;
    use UniversityTrait;

    /**
     * @var \University\V1\Service\University
     */
    protected $universityService;

    public function __construct($userProfileMapper, $universityMapper)
    {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUniversityMapper($universityMapper);
    }
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $data = (array) $data;
        $inputFilter = $this->getInputFilter();

        try {
         
            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getUniversityService()->createUniversity($inputFilter);
        } catch (Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $result;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        try {
            $university = $this->getUniversityMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($university)) {
                return new ApiProblem(404, "University data Not Found");
            }
            return $this->getUniversityService()->delete($university);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $university;
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $university = $this->universityMapper->fetchOneBy(['uuid' => $id]);
        if (!$university) {
            return new ApiProblemResponse(new ApiProblem(404, "Data not found"));
        }
        return $university;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }
        

       
        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        if (isset($queryParams['asc'])) {
            $asc = $queryParams['asc'];
            unset($queryParams['asc']);
        }
        $queryParams = [];
        $qb = $this->universityMapper->fetchAll($queryParams);
        $paginatorAdapter = $this->universityMapper->createPaginatorAdapter($qb);
        // return new ZendPaginator($paginatorAdapter);
        return new Paginator($paginatorAdapter);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $university = $this->getUniversityMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($university)) {
            return new ApiProblemResponse(new ApiProblem(404, "University data not found!"));
        }
        $inputFilter = $this->getInputFilter();
        $this->getUniversityService()->update($university, $inputFilter);
        return $university;
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

     /**
     * Get the value of universityService
     */
    public function getUniversityService()
    {
        return $this->universityService;
    }

    /**
     * Set the value of universityService
     *
     * @return  self
     */
    public function setUniversityService($universityService)
    {
        $this->universityService = $universityService;

        return $this;
    }
}
