<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 18/11/2017
 * Time: 16:21
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{

    public function articlePublish()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.publier', true));

        return $qb->getQuery()->getResult();
    }

}