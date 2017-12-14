<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 14/12/2017
 * Time: 11:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * Class Image
 * @package AppBundle\Entity
 */
class Image
{

    protected static $path = 'img/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $nameComplet;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNameComplet()
    {
        return $this->nameComplet;
    }

    /**
     * @param mixed $nameComplet
     */
    public function setNameComplet($nameComplet)
    {
        $this->nameComplet = $nameComplet;
    }

    public function getPathFichier(){
        return self::$path.$this->getNameComplet();
    }

}