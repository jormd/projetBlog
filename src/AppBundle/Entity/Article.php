<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 11/11/2017
 * Time: 19:22
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArticleRepository")
 * @ORM\Table(name="Article")
 * Class Article
 * @package AppBundle\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title = 'Ceci est un titre';

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $body = 'ceci est le corps';

    /**
     * @ORM\Column(type="date")
     */
    protected $created;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $publier = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $datePublication;

    /**
     * Article constructor.
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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getPublier()
    {
        return $this->publier;
    }

    /**
     * @param mixed $publier
     */
    public function setPublier($publier)
    {
        $this->publier = $publier;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * @return Date
     */
    public function getDatePublication(): DateTime
    {
        return $this->datePublication;
    }

    /**
     * @param Date $datePublication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    }



}