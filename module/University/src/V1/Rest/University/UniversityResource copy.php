<?php

namespace University\V1\Rest\University;

use University\Mapper\UniversityTrait;
use User\Mapper\UserAclTrait;
use User\Mapper\UserProfileTrait;
use User\V1\Rest\AbstractResource;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class UniversityResourceCopy extends AbstractResource
{
    use UserProfileTrait;
    use UniversityTrait;

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
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        // if (!is_array($params) && method_exists($params, 'toArray'))
        //     $urlParams = $params->toArray();
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(401, 'You\'re not authorized'));
        }
        $urlParams = [];
        // if (($userProfile->getAccount() ?? null) !== null) {
        //     $urlParams['account_uuid']    = $userProfile->getAccount()->getUuid();
        // }
        // $order = null;
        // $asc = false;
        // if (isset($queryParams['order'])) {
        //     $order = $queryParams['order'];
        //     unset($queryParams['order']);
        // }
        // if (isset($queryParams['ascending'])) {
        //     $asc = $queryParams['ascending'];
        //     unset($queryParams['ascending']);
        // }
        $qb = $this->universityMapper->fetchAll($urlParams);
        $paginatorAdapter = $this->universityMapper->createPaginatorAdapter($qb);
        return new Paginator($paginatorAdapter);
        // return new ApiProblem(405, 'The GET method has not been defined for collections');
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
