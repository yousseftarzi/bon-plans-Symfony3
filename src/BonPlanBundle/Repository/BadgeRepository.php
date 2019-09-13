<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 04/04/2018
 * Time: 18:06
 */

namespace BonPlanBundle\Repository;


class BadgeRepository extends \Doctrine\ORM\EntityRepository
{
    public  function TotalReservation($id)
    {
        return
        $query=$this->getEntityManager()->createQuery("SELECT  COUNT (h) From BonPlanBundle:Historique h WHERE h.action='reserver' AND h.loginBonPlaneur=:id ")
        ->setParameter('id',$id)
        ->setMaxResults(1)
            ->getSingleResult();


//        return $query->getResult();
    }


    public  function TotalEvaluation($id)
    {
        return
            $query = $this->getEntityManager()->createQuery("SELECT  COUNT (h) From BonPlanBundle:Historique h WHERE h.action='evaluer' AND h.loginBonPlaneur=:id ")
                ->setParameter('id', $id)
                ->setMaxResults(1)
                ->getSingleResult();
    }

    public  function TotalNote($id)
    {
        return
            $query = $this->getEntityManager()->createQuery("SELECT  COUNT (h) From BonPlanBundle:Historique h WHERE h.action='noter' AND h.loginBonPlaneur=:id ")
                ->setParameter('id', $id)
                ->setMaxResults(1)
                ->getSingleResult();
    }

    public  function TotalPublication($id)
    {
        return
            $query = $this->getEntityManager()->createQuery("SELECT  COUNT (h) From BonPlanBundle:Historique h WHERE h.action='publier' AND h.loginBonPlaneur=:id ")
                ->setParameter('id', $id)
                ->setMaxResults(1)
                ->getSingleResult();
    }

}