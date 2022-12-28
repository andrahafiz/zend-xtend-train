<?php
namespace University\V1\Rest\Major;

class MajorResourceFactory
{
    public function __invoke($services)
    {
        return new MajorResource();
    }
}
