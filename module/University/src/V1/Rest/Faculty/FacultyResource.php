<?php

namespace University\V1\Rest\Faculty;

use Exception;
use University\Mapper\FacultyTrait;
use User\Mapper\UserAclTrait;
use User\Mapper\UserProfileTrait;
use User\V1\Rest\AbstractResource;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class FacultyResource extends AbstractResource
{
    use UserProfileTrait;
    use FacultyTrait;

    /**
     * @var \University\V1\Service\Faculty
     */
    protected $facultyService;

    public function __construct($userProfileMapper, $facultyMapper)
    {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setFacultyMapper($facultyMapper);
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

            $result = $this->getFacultyService()->createFaculty($inputFilter);
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
        $faculty = $this->facultyMapper->fetchOneBy(['uuid' => $id]);
        if (!$faculty) {
            return new ApiProblemResponse(new ApiProblem(404, "Data not found"));
        }
        return $faculty;
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
        $qb = $this->facultyMapper->fetchAll($queryParams);
        $paginatorAdapter = $this->facultyMapper->createPaginatorAdapter($qb);
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
     * Get the value of facultyService
     */
    public function getFacultyService()
    {
        return $this->facultyService;
    }

    /**
     * Set the value of facultyService
     *
     * @return  self
     */
    public function setFacultyService($facultyService)
    {
        $this->facultyService = $facultyService;

        return $this;
    }
}
