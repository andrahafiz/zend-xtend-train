<?php
namespace Student\V1\Rest\Student;

class StudentResourceFactory
{
    public function __invoke($services)
    {
        return new StudentResource();
    }
}
