<?php

namespace University\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use University\Entity\University;

/**
 * Class UniversityStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class UniversityStrategy implements StrategyInterface
{
    protected $logoUrl;

    public function __construct($logoUrl = null)
    {
        $this->setLogoUrl($logoUrl);
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a User
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        if ($value instanceof University && ! is_null($value)) {
            $values = [
                "uuid" => $value->getUuid(),
                "name" => $value->getName(),
                "address"  => $value->getAddress(),
                "logo"  => $this->logoUrl. '/'. $value->getLogo(),
            ];

            return $values;
        }

        return null;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     * @throws \InvalidArgumentException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function hydrate($value, array $data = null)
    {
        return $value;
    }


    /**
     * Get the value of logoUrl
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * Set the value of logoUrl
     *
     * @return  self
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }
}
