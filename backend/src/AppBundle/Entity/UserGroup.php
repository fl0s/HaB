<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group;

/**
 * @ORM\Entity
 */
class UserGroup extends Group
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $pictureSlug;

    public function getId()
    {
        return $this->id;
    }

    public function getPictureSlug()
    {
        return $this->pictureSlug;
    }

    public function setPictureSlug($slug)
    {
        $this->pictureSlug = $slug;
    }

    public function __toString()
    {
        return $this->name;
    }
}
