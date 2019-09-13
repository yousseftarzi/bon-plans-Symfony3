<?php

namespace BonPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    public function indexAction()
    {
        return $this->render('CategorieBundle:Default:index.html.twig');
    }

    public function afficherCategorieAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository('BonPlanBundle:Categorie')->findAll();

        return $this->render("BonPlanBundle::Categorie.html.twig",array('c'=>$categorie));

    }

    public function afficherBonplanByCatAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        
        $bonplan=$em->getRepository('BonPlanBundle:BonPlan')->findBy(array('idCategorie'=>$id));

        $dql   = "SELECT a FROM BonPlanBundle:BonPlan a WHERE a.idCategorie=".$id."";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );

        return $this->render("BonPlanBundle::Deals.html.twig",array('BonPlans'=>$pagination));


    }
}
