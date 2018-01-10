<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 25/11/2017
 * Time: 16:13
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

class CommentaireRepository extends EntityRepository
{
    public function findByUser(User $user){
        $qb = $this->createQueryBuilder('c');

        $qb->innerJoin('c.article', 'article')
            ->innerJoin('article.auteur', 'auteur', 'with', 'auteur.id = :auteur')
            ->setParameter('auteur', $user->getId())
            ->orderBy('c.dateCreation', 'DESC')
            ->setMaxResults(15);

        return $qb->getQuery()->getResult();
    }

    public function findAllCommentaire(){
        $qb = $this->createQueryBuilder('c');

        $qb->innerJoin('c.article', 'article')
            ->orderBy('c.dateCreation', 'DESC')
            ->setMaxResults(15);

        return $qb->getQuery()->getResult();
    }
}