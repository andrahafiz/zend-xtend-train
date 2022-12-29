<?php

namespace University\V1\Rest\Major;

use Exception;
use University\Mapper\MajorTrait;
use User\Mapper\UserAclTrait;
use User\Mapper\UserProfileTrait;
use User\V1\Rest\AbstractResource;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class MajorResource extends AbstractResource
{
    use UserProfileTrait;
    use MajorTrait;

    /**
     * @var \University\V1\Service\Major
     */
    protected $majorService;

    public function __construct($userProfileMapper, $majorMapper)
    {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setMajorMapper($majorMapper);
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

            $result = $this->getMajorService()->createMajor($inputFilter);
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
            $room = $this->getMajorMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($room)) {
                return new ApiProblem(404, "Major data Not Found");
            }
            return $this->getMajorService()->delete($room);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $room;
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
        $major = $this->majorMapper->fetchOneBy(['uuid' => $id]);
        if (!$major) {
            return new ApiProblemResponse(new ApiProblem(404, "Data not found"));
        }
        return $major;
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
        $qb = $this->majorMapper->fetchAll($queryParams);
        $paginatorAdapter = $this->majorMapper->createPaginatorAdapter($qb);
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
    $room = $this->getMajorMapper()->fetchOneBy(['uuid' => $id]);
    if (is_null($room)) {
        return new ApiProblemResponse(new ApiProblem(404, "Major data not found!"));
    }
    $inputFilter = $this->getInputFilter();

    $this->getMajorService()->update($room, $inputFilter);
    return $room;
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
     * Get the value of majorService
     */
    public function getMajorService()
    {
        return $this->majorService;
    }

    /**
     * Set the value of majorService
     *
     * @return  self
     */
    public function setMajorService($majorService)
    {
        $this->majorService = $majorService;

        return $this;
    }
}
