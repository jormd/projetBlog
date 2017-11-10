<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 10/11/2017
 * Time: 18:30
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\User as BaseUser;


/**
 * @ORM\ENTITY
 * @ORM\Table(name="user")
 * Class User
 * @package UserBundle\Entity
 */
class User extends BaseUser
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * User constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}