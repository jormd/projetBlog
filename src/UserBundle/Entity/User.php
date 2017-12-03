<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 10/11/2017
 * Time: 18:30
 */

namespace UserBundle\Entity;

use AppBundle\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Article", mappedBy="auteur")
     */
    protected $articles;


    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param ArrayCollection $articles
     */
    public function setArticles(ArrayCollection $articles)
    {
        $this->articles = $articles;
    }

    public function addArticle(Article $article)
    {
        $this->articles->add($article);
    }

    public function removeArticle(Article $article)
    {
        $this->articles->remove($article);
    }

}