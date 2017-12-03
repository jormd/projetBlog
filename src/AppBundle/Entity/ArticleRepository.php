<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 18/11/2017
 * Time: 16:21
 */

namespace AppBundle\Entity;


use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

class ArticleRepository extends EntityRepository
{

    public function articlePublish()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true));

        return $qb->getQuery()->getResult();
    }

    public function oneArticlePublish(Article $article)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true))
            ->andWhere($qb->expr()->eq('a.id', ':id'))
            ->leftJoin('a.commentaires', 'commentaires')
            ->setParameter('id', $article->getId());

        return $qb->getQuery()->getResult();
    }

    public function lastArticlePublish()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true))
            ->andWhere($qb->expr()->eq('a.datePublication', ':param'))
            ->setParameter('param', $this->maxArticleDate(), Type::DATETIME)
            ->leftJoin('a.commentaires', 'commentaires')
        ;

        return $qb->getQuery()->getResult();
    }

    public function maxArticleDate()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select($qb->expr()->max('a.datePublication'));

        return $qb->getQuery()->getResult();
    }

    public function findByUser(User $user){
        $qb = $this->createQueryBuilder('a');

        $qb->innerJoin('a.auteur', 'auteur', 'with', 'auteur.id = :auteur')
            ->setParameter('auteur', $user->getId())
            ->orderBy('a.created', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

}