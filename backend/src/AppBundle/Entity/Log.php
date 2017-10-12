<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Log
{
    const USER_LOGIN = 'user_login';
    const REPORT_PRINT = 'report_print';

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="logs")
     */
    private $user;

    /**
     * @var |DateTime
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct(User $user, $type)
    {
        $this->date = new \DateTime();
        $this->type = $type;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDate()
    {
        return $this->date;
    }
}
