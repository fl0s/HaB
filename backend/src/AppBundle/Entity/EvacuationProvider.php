<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class EvacuationProvider
{
    use IdentifiableTrait;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name = "";

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type = "";

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
