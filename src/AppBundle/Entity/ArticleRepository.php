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

class ArticleRepository extends EntityRepository
{

    public function articlePublish()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true));

        return $qb->getQuery()->getResult();
    }

    public function lastArticlePublish()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true))
            ->andWhere($qb->expr()->eq('a.datePublication', ':param'))
            ->setParameter('param', $this->maxArticleDate(), Type::DATETIME)
            ->innerJoin('a.commentaires', 'commentaires')
        ;

        return $qb->getQuery()->getResult();
    }

    public function maxArticleDate()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select($qb->expr()->max('a.datePublication'));

        return $qb->getQuery()->getResult();
    }

}