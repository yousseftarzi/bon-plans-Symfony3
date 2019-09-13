<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 13/04/2018
 * Time: 08:26
 */

namespace BonPlanBundle\Controller;


use BonPlanBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends  Controller
{
    public function addAction (Request $req){


        $em=$this->getDoctrine()->getManager();
        $reservation = new Reclamation();
        //$bonplan=$em->getRepository('BonPlanBundle:BonPlan')->find($id);


        //$bonplan->getId();
        //$reservation->setIdBonPlan( $bonplan);
        $iduser=$em->getRepository('BonPlanBundle:Utilisateur')->find($this->getUser()->getId());
        $reservation->setIdsource($iduser);
        $form = $this->createForm("BonPlanBundle\Form\ReclamationType",$reservation);
        $form->handleRequest($req);
        $formview = $form->createView();

        if ($form->isSubmitted()){
            //$user = $this->get('security.token_storage')->getToken()->getUser();

            // $reservation->setIdBonPlaneur($user);

            $em->persist($reservation);
            $em->flush();
            $user=$this->getUser();


            $message = \Swift_Message:: newInstance()
                ->setSubject('Contact Form Submission')
                ->setFrom($user->getEmail())
                ->setTo('youssef.rebai@esprit.tn')
                ->setBody(
                    $reservation->getMessage(),
                    'text/plain'
                )
            ;
            $this->get('mailer')->send($message);


            return $this->redirectToRoute('home');
        }

        return $this->render('BonPlanBundle:Abonnement:Reclamation.html.twig',array('form'=>$formview,'Abonnements'=>$reservation));
    }
}