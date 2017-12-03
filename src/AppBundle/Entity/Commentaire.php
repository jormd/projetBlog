<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 23/11/2017
 * Time: 19:44
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Commentaire
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommentaireRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $texte;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreation;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article", inversedBy="commentaires")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected $article;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param string $texte
     */
    public function setTexte(string $texte)
    {
        $this->texte = $texte;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return string
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param string $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreation = new \DateTime("now");
    }

}