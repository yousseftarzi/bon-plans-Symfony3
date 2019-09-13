<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 05/04/2018
 * Time: 14:15
 */

namespace BonPlanBundle\Repository;


class EvaluationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findProfessionnel()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT pro FROM BonPlanBundle:Utilisateur pro WHERE pro.role ='professionnel' ");
        return $query->getResult();
    }
    //liste des pro evalue par currentUser
    public function findProfessionnelEvalue($currentUserId)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT pro FROM BonPlanBundle:Utilisateur pro JOIN BonPlanBundle:Evaluation eval WITH pro.id=eval.idProfessionnel WHERE eval.idBonPlaneur=:id")
            ->setParameter('id',$currentUserId);

        return $query->getResult();
    }

    public function getCategoriePro($idPro)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT u FROM BonPlanBundle:Utilisateur u where u.id=:idPro")
            ->setParameter('idPro', $idPro);
        $idCategorie= $query->getResult();
        return $idCategorie;
    }

    public function getCriterePro($idCategorie)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT crit FROM BonPlanBundle:Critere crit where crit.idCategorie=:idCategorie")
            ->setParameter('idCategorie', $idCategorie);
        return $query->getResult();
    }

    public function getBonsPlansByCategorie($categorie)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT bonsPlans FROM BonPlanBundle:BonPlan bonsPlans where bonsPlans.idCategorie=:categorie")
            ->setParameter('categorie', $categorie);
        return $query->getResult();
    }
}