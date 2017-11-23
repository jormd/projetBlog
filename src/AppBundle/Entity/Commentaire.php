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
 * @ORM\Entity()
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTexte(): string
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

}