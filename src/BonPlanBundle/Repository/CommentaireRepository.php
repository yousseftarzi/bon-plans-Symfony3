<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 11/04/2018
 * Time: 18:01
 */

namespace BonPlanBundle\Repository;


class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function findMotInterdit($commentaire,$motInterdit)
    {
        $query = $this->getEntityManager()
            ->createQuery("select comm.contenu from BonPlanBundle:Commentaire comm join BonPlanBundle:MotInterdit mot where :commentaire like concat('%',:motInterdit,'%')")
            ->setParameter('commentaire', $commentaire)
            ->setParameter('motInterdit', $motInterdit);

        return $query->getResult();
    }

}