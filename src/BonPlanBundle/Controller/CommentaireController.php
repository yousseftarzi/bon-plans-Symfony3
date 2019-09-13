<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\Commentaire;
use BonPlanBundle\Form\CommentaireType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommentaireController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function afficherBonPlanAction(Request $request)
    {
        ///////gros////
        $entityManager = $this->getDoctrine()->getManager();
        $motsInterdits=  $entityManager->getRepository("BonPlanBundle:MotInterdit")->findAll();
        /// /////////////
        $id=1;
        $comments=$entityManager->getRepository("BonPlanBundle:Commentaire")->findBy(['idBonPlan'=>$id]);
        /////
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {

        foreach ($motsInterdits as $motInterdit)
        {
            if (strpos($commentaire->getContenu(), $motInterdit->getTexte()) !== false)
            {
                $this->get('session')->getFlashBag()->add('notice', 'Commentaire non autorisé à cause d un mot interdit!');
                return $this->redirectToRoute('/singleBp/1');
            }
        }

            $commentaire->setIdAuteur($this->getUser());
            //$commentaire->setIdBonPlan($request->get('idBonPlan'));
            $commentaire->setIdBonPlan($entityManager->find("BonPlanBundle:BonPlan",$id));
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('single_bon_plan');
        }

        return $this->render('@BonPlan/Commentaire/singleBonPlan.html.twig', array(
            'form' => $form->createView(),'comments'=>$comments,'currentUser'=>$this->getUser()
        ));
    }


    public function ModifierCommentaireAction(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $id=$request->get('id');
        $idBonPlan=$request->get('idBonPlan');
        $commentaire=$entityManager->getRepository("BonPlanBundle:Commentaire")->findOneBy(['id'=>$id]);
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('singleBonPlan', array('id' => $idBonPlan));
        }
        return $this->render("BonPlanBundle:Commentaire:modifierCommentaire.html.twig",array('form'=>$form->createView()));
    }



    public function SupprimerCommentaireAction(Request $request)
    {
        $id=$request->get('id');
        $idBonPlan=$request->get('idBonPlan');
        $entityManager=$this->getDoctrine()->getManager();
        $commentaire=$entityManager->getRepository("BonPlanBundle:Commentaire")->find($id);
        $entityManager->remove($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('singleBonPlan', array('id' => $idBonPlan));
    }

/*
    public function ajouterCommentaireAction(Request $request)
    {
        $commentaire = new Commentaire();
        $commentaire->setIdAuteur($this->getUser());
        $commentaire->setIdBonPlan($request->get('id'));
        //$date =  date_timestamp_get(:'\now')    date('d/m/Y h:i:s a', time());
        //$commentaire->setDateCreation($date);
        $form = $this->createForm(CommentaireType::class, $commentaire);
         $form->handleRequest($request);
         //controle de saisie ne9es
        if ($form->isSubmitted())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('single_bon_plan');
        }

        return $this->render('@BonPlan/Commentaire/singleBonPlan.html.twig', array(
            'form' => $form->createView(),
        ));
    }
           /*foreach ($motsInterdits as $motInterdit)
           {

               //$grosMot=$motInterdit->getTexte();
               //if (preg_match("/\b $grosMot \b/", $commentaire->getContenu()))
                   //echo "E7chem 3asba";
               //else echo "mrigel";


           }


        if ($form->isValid())
        {
            $commentaire->setIdAuteur($this->getUser());
            //$commentaire->setIdBonPlan($request->get('idBonPlan'));
            $commentaire->setIdBonPlan($entityManager->find("BonPlanBundle:BonPlan",$id));
            //check mot interdit
            for($i=0;$i<count($motsInterdits);$i++)
            {
                $CommInterdit=$entityManager->getRepository("BonPlanBundle:Commentaire")->
                findMotInterdit($commentaire->getContenu(),$motsInterdits[$i]->getTexte());
            }
            if (empty($CommInterdit)) {
                $entityManager->persist($commentaire);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Commentaire ajouté!'
                );
            }
            else
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Commentaire non autorisé à cause d un mot interdit!'
                );

            return $this->redirectToRoute('single_bon_plan',array('id'=>$id));
        }



*/
}
