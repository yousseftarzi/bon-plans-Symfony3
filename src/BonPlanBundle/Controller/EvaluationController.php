<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\BonPlanBundle;
use BonPlanBundle\Entity\BonPlan;
use BonPlanBundle\Entity\Evaluation;
use BonPlanBundle\Entity\MoyenneCritere;
use BonPlanBundle\Entity\NotesCriteres;
use BonPlanBundle\Entity\Utilisateur;
use BonPlanBundle\Form\NoteCritereType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

class EvaluationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function afficherProAction()
    {
        $em=$this->getDoctrine()->getManager();
        $professionnels=$em->getRepository("BonPlanBundle:Evaluation")->findProfessionnel();
        $proEvalues=$em->getRepository("BonPlanBundle:Evaluation")->findProfessionnelEvalue($this->getUser());
        $i=0;
        if(count($proEvalues)>0)
        {
        foreach ($proEvalues as $pro)
        {
          if($professionnels[$i]->getId()==$pro->getId())
          {
              unset($professionnels[$i]);

          }
          $i++;
        }
        }
        return $this->render('@BonPlan/Evaluation/listeProfessionnel.html.twig',array('professionnels'=>$professionnels));

    }

    public function initEvaluationAction(Request $request)
    {
        $idPro=$request->get('id');
        $idCategorie=$request->get('idCategorie');
        $em=$this->getDoctrine()->getManager();
        $criteres=$em->getRepository("BonPlanBundle:Evaluation")->getCriterePro($idCategorie);
        return $this->render('@BonPlan/Evaluation/initEvaluation.html.twig',array('criteres'=>$criteres, 'idPro'=>$idPro,'idCategorie'=>$idCategorie));
    }

    public function ajouterEvaluationAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $currentUser= $this->getUser();
        $idPro=$request->get('idPro');
        $professionnel=$em->getRepository("BonPlanBundle:Utilisateur")->findOneBy(['id'=>$idPro]);
//Ajout Evaluation
        $evaluation=new Evaluation();
        $evaluation->setIdBonPlaneur($currentUser);
        $evaluation->setIdProfessionnel($professionnel);
        $em->persist($evaluation);
        $em->flush();
//Ajout note dans table note_critere
        $idCategorie=$request->get('idCategorie');
        $criteres=$em->getRepository("BonPlanBundle:Critere")->findBy(['idCategorie'=>$idCategorie]);
        foreach ($criteres as $critere) {
            $noteCritere = new NotesCriteres();
            $noteCritere->setIdCritere($critere);
            $noteCritere->setIdEvaluation($evaluation);
            $noteCritere->setNote($request->get($critere->getId()));//badelha note fel html
            $em->persist($noteCritere);
            $em->flush();
            //Update or ajout moyenne dans table moyenne_critere
            $moyenne=$this->calculMoyenneAction($critere->getId(),$idPro);
            $moyenneExiste = $em->getRepository("BonPlanBundle:MoyenneCritere")
                ->findOneBy(['idCritere' => $critere, 'idProfessionnel' => $professionnel]);
            if($moyenneExiste==null)
            {
                $moyenneCritere= new MoyenneCritere();
                $moyenneCritere->setIdProfessionnel($professionnel);
                $moyenneCritere->setIdCritere($critere);
                $moyenneCritere->setNote($moyenne);
                $em->persist($moyenneCritere);
            }
            else $moyenneExiste->setNote($moyenne);

            $em->flush();
       }

        return $this->redirectToRoute('liste_Professionnel');
    }
    //Afficher les Professionnels qui ont ete evalué par l'utilisateur avec options modif&supp
    public function afficherMesEvaluationAction()
    {
        $entityManager=$this->getDoctrine()->getManager();
        $currentUserId=$this->getUser()->getId();
        $myEvals=$entityManager->getRepository("BonPlanBundle:Evaluation")->findBy(['idBonPlaneur'=>$currentUserId]);
        return $this->render('@BonPlan/Evaluation/mesEvaluations.html.twig',array('myEvals'=>$myEvals));
    }

    public function chargerEvaluationAction(Request $request)
    {
        $idEvaluation=$request->get('idEvaluation');
        $entityManager=$this->getDoctrine()->getManager();
        $notesCriteres=$entityManager->getRepository("BonPlanBundle:NotesCriteres")->findBy(['idEvaluation'=>$idEvaluation]);
        return $this->render('@BonPlan/Evaluation/chargerEvaluation.html.twig', array('notesCriteres'=>$notesCriteres,'idEvaluation'=>$idEvaluation));
    }

    public function modifierEvaluationAction(Request $request)
    {
      $entityManager=$this->getDoctrine()->getManager();
      $idEvaluation=$request->get('idEvaluation');
      $notesCriteres=$entityManager->getRepository("BonPlanBundle:NotesCriteres")->findBy(['idEvaluation'=>$idEvaluation]);
      foreach ($notesCriteres as $noteCritere)
      {
          $noteCritere->setNote($request->get($noteCritere->getId()));
          $entityManager->persist($noteCritere);
          $entityManager->flush();
      }
        return $this->redirectToRoute('mes_evaluations');
    }

    public function supprimerEvaluationAction(Request $request)
    {
        $idEvaluation=$request->get('idEvaluation');
        $entityManager=$this->getDoctrine()->getManager();
        $notesCriteres=$entityManager->getRepository("BonPlanBundle:NotesCriteres")->findBy(['idEvaluation'=>$idEvaluation]);
        foreach ($notesCriteres as $noteCritere)
        {
            //suppression des notes;
            $entityManager->remove($noteCritere);
            $entityManager->flush();
            //MAJ OU Suppression moyenneCritere
            $idCritere=$noteCritere->getIdCritere()->getId();
            $idPro=$noteCritere->getIdEvaluation()->getIdProfessionnel()->getId();
            $moyenne=$this->calculMoyenneAction($idCritere,$idPro);
            $moyenneCritere=$entityManager->getRepository("BonPlanBundle:MoyenneCritere")->findOneBy(['idProfessionnel'=>$idPro,'idCritere'=>$idCritere]);
            if($moyenne!=-1) $moyenneCritere->setNote($moyenne);         //moyenne=-1 =>pas de notesCriteres dans la table
            else $entityManager->remove($moyenneCritere);
            $entityManager->flush();
        }
        //Suppression de l'evaluation
        $evaluation=$entityManager->getRepository("BonPlanBundle:Evaluation")->findOneBy(['id'=>$idEvaluation]);
        $entityManager->remove($evaluation);
        $entityManager->flush();

        return $this->redirectToRoute('mes_evaluations');
    }

    public  function calculMoyenneAction($idCritere, $idPro)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $evaluationsPro=$entityManager->getRepository("BonPlanBundle:Evaluation")->findBy(['idProfessionnel'=>$idPro]);
        $notesCritere=$entityManager->getRepository("BonPlanBundle:NotesCriteres")->findBy(['idCritere'=>$idCritere,'idEvaluation'=>$evaluationsPro]);
        if(count($notesCritere)>0) {
            $moyenne = 0;
            foreach ($notesCritere as $noteCritere)
                $moyenne += $noteCritere->getNote();
            $moyenne=$moyenne/count($notesCritere);
        }
        else $moyenne=-1;
        return $moyenne;
    }

    public function topCategorie()
    {
        $topCatgories=-1;
        $currentUser=$this->getUser();
        $entityManager=$this->getDoctrine()->getManager();
        $commentaires=$entityManager->getRepository("BonPlanBundle:Commentaire")->findBy(['idAuteur'=>$currentUser]);
        if($commentaires==null)
            return $topCatgories;
        else {
            foreach ($commentaires as $comment)
                $bonsPlans[] = $entityManager->getRepository('BonPlanBundle:BonPlan')->findOneBy(['id' => $comment->getIdBonPlan()]);
            foreach ($bonsPlans as $bonPlan)
                $categoriesComm[] = $bonPlan->getIdCategorie();
            //Recuperations des categories de la BD
            $categoriesDb = $entityManager->getRepository("BonPlanBundle:Categorie")->findAll();
            foreach ($categoriesDb as $catg)
                $catgDistinct[$catg->getId()] = 0;
            //Nombre de commentaire par categorie
            foreach ($catgDistinct as $key => $value)
                foreach ($categoriesComm as $category)
                    if ($category->getId() == $key)
                        $catgDistinct[$category->getId()] += 1;

            uasort($catgDistinct, function ($a, $b) {
                return $b - $a;
            });

            if (count($catgDistinct) > 1)
                $topCatgories = array_slice($catgDistinct, 0, 2, $preserve_keys = true);
            else $topCatgories = $catgDistinct;
        }
        $topCatgories=array_keys($topCatgories);
        return $topCatgories;
    }

    public function afficherRecommandationAction()
    {
        $Erreur="Veuillez Interagir plus pour bénéficiez des recommandations!!";
        $entityManager=$this->getDoctrine()->getManager();
        $topCategories=$this->topCategorie();
        $bonsPlans[]=new BonPlan();
        if($topCategories!=-1) {
            $bonsPlans=$entityManager->getRepository("BonPlanBundle:BonPlan")->findBy(['idCategorie' => array_values($topCategories)]);
            if(count($bonsPlans)>4)
                $bonsPlans = array_slice($bonsPlans, 0, 4, $preserve_keys = true);
///////////////////////////////
          /*  $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    '@BonPlan/Evaluation/recommandation.html.twig',
                    array(
                        'bonsPlans'  => $bonsPlans
                    )
                ),
                'C:/file.pdf'
            );*/
            /////////////////
            return $this->render('@BonPlan/Evaluation/recommandation.html.twig',array('bonsPlans'=>$bonsPlans));
        }
        else return $this->render('@BonPlan/Evaluation/recommandation.html.twig',array('Erreur'=>$Erreur));
    }

    public function singleEvaluationAction(Request $request)
    {
        $idPro=$request->get('id');
        $idUser=$this->getUser();
        $entityManager=$this->getDoctrine()->getManager();
        $notesMoyennes=$entityManager->getRepository("BonPlanBundle:MoyenneCritere")->findBy(['idProfessionnel'=>$idPro]);
        return $this->render('@BonPlan/Evaluation/singleEvaluation.html.twig',array('notesMoyennes'=>$notesMoyennes));
    }

    public function pdfAction()
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('BonPlanBundle::pdf.html.twig', array(
            'title' => 'Hello World !'
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }



    //mochkla fel affichage dynamique
    /*public function modifierEvaluationAction(Request $request)
    {
        $noteCritere = new NotesCriteres();
        $form = $this->get('form.factory')->create(NoteCritereType::class, $noteCritere);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $noteCritere->setIdCritere()
            $em->persist($noteCritere);
            $em->flush();

            return $this->redirectToRoute('mes_evaluations', array());
        }

        return $this->render('BonPlanBundle:Evaluation:chargerEvaluation.html.twig', array(
            'form' => $form->createView(),
        ));
    }*/




}
