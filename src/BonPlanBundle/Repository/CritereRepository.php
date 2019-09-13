<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 11/04/2018
 * Time: 11:19
 */

namespace BonPlanBundle\Repository;


class CritereRepository  extends \Doctrine\ORM\EntityRepository
{

    public function getIdCatbyId($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT cc FROM BonPlanBundle:Critere cc where cc.id=:id")
            ->setParameter('id',$id);

        return $query->getResult();
    }

    public function getByIdCategorie($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT cc FROM BonPlanBundle:Critere cc where cc.idCategorie=:id")
            ->setParameter('id',$id);

        return $query->getResult();
    }

//evaluation
    public function getCriterePro($idCategorie)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT crit FROM BonPlanBundle:Critere crit where crit.idCategorie=:idCategorie")
            ->setParameter('idCategorie', $idCategorie);
        return $query->getResult();
    }

}