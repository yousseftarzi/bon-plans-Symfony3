<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\MotInterdit;
use BonPlanBundle\Form\MotInterditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BonPlanBundle\Entity\Critere;
use BonPlanBundle\Form\CritereType;
//use BonPlanBundle\Form\CritereSupprimerType;
use BonPlanBundle\Form\ModifierCritereType;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('BonPlanBundle:Admin:admin.html.twig');
    }

    public function categorieAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("BonPlanBundle:Categorie")->findAll();

        return $this->render('BonPlanBundle:Admin:categorie.html.twig',array('c'=>$categorie));
    }

    public function bonPlanAction()
    {
        $em=$this->getDoctrine()->getManager();
        $bonPlan=$em->getRepository("BonPlanBundle:BonPlan")->findAll();

        return $this->render('BonPlanBundle:Admin:BonPlan.html.twig',array('c'=>$bonPlan));

    }

    public function SupprimerbonPlanAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $bonPlan=$em->getRepository("BonPlanBundle:BonPlan")->find($id);



        $em->remove($bonPlan);
        $em->flush();

        $bonPlan=$em->getRepository("BonPlanBundle:BonPlan")->findAll();

      //  return $this->redirectToRoute('modifiercategorie_admin',array('id'=>$bonPlan));
        return $this->render('BonPlanBundle:Admin:BonPlan.html.twig',array('c'=>$bonPlan));

    }

    public function modifierCategorieAction(Request $request,$id)
    {
        $critere= new Critere();
        $em=$this->getDoctrine()->getManager();

        $criteree=$em->getRepository("BonPlanBundle:Critere")->getIdCatbyId($id);

        $critere->setIdCategorie($id);

        $critere =$em->getRepository("BonPlanBundle:Critere")->findBy(array('idCategorie'=>$id));

        $critereaajouter=new Critere();
        $Form=$this->createForm(CritereType::class,$critereaajouter);
        $Form->handleRequest($request);

        if ($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            //var_dump($critereaajouter);
            $categorie=$em->getRepository("BonPlanBundle:Categorie")->find($id);
            $critereaajouter->setIdCategorie($categorie);
            $em->persist($critereaajouter);
            $em->flush();


            return $this->render('BonPlanBundle:Admin:critere.html.twig',array('c'=>$critere,'form'=>$Form->createView()));
        }

        $em=$this->getDoctrine()->getManager();
        $critere=$em->getRepository("BonPlanBundle:Critere")->findBy(array('idCategorie'=>$id));


        return $this->render('BonPlanBundle:Admin:critere.html.twig',array('c'=>$critere,'form'=>$Form->createView()));

    }

   /* public function modifierCritereAction($id)
    {

        return $this->redirectToRoute('modifiercritere_admin');

    }*/


    public function supprimerCritereAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $critere=$em->getRepository("BonPlanBundle:Critere")->find($id);


        $criteree=$em->getRepository("BonPlanBundle:Critere")->getIdCatbyId($id);

        //var_dump($criteree[0]->getIdCategorie()->getId());

        $critereee=$em->getRepository("BonPlanBundle:Critere")->getByIdCategorie($criteree[0]->getIdCategorie()->getId());


        $em->remove($critere);
        $em->flush();

        $idCat=$criteree[0]->getIdCategorie()->getId();


        $critere =$em->getRepository("BonPlanBundle:Critere")->findBy(array('idCategorie'=>$idCat));

        return $this->redirectToRoute('modifiercategorie_admin',array('id'=>$idCat));

    }

    public function modifierCritereAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $critere=$em->getRepository("BonPlanBundle:Critere")->find($id);


        $criteree=$em->getRepository("BonPlanBundle:Critere")->getIdCatbyId($id);

        //var_dump($criteree[0]->getIdCategorie()->getId());

        $critereee=$em->getRepository("BonPlanBundle:Critere")->getByIdCategorie($criteree[0]->getIdCategorie()->getId());

        $Form=$this->createForm(ModifierCritereType::class,$critere);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {


            $em->persist($critere);
            $em->flush();


            $criteree=$em->getRepository("BonPlanBundle:Critere")->getIdCatbyId($id);


            $critere =$em->getRepository("BonPlanBundle:Critere")->findBy(array('idCategorie'=>$id));
            $idCategorie=$criteree[0]->getIdCategorie()->getId();

            $critereaajouter=new Critere();
            $FormAjout=$this->createForm(CritereType::class,$critereaajouter);
            $FormAjout->handleRequest($request);

            if ($FormAjout->isValid()) {
                $em = $this->getDoctrine()->getManager();
                var_dump($critereaajouter);
                $categorie = $em->getRepository("BonPlanBundle:Categorie")->find($idCategorie);
                $critereaajouter->setIdCategorie($categorie);
                $em->persist($critereaajouter);
                $em->flush();

                return $this->render('BonPlanBundle:Admin:critere.html.twig',array('c'=>$critere,'form'=>$FormAjout->createView()));


            }
            return $this->render("BonPlanBundle:Admin:critere.html.twig",array('c'=>$critereee,'form'=>$FormAjout->createView()));

        }


        return $this->render('BonPlanBundle:Admin:modifierCritere.html.twig',array('c'=>$critere,'form'=>$Form->createView()));

    }

    public function afficherMotInterditAction(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $motsInterdits=$entityManager->getRepository("BonPlanBundle:MotInterdit")->findAll();

        $motInterdit=new MotInterdit();
        $form=$this->createForm(MotInterditType::class,$motInterdit);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $entityManager->persist($motInterdit);
            $entityManager->flush();
            return $this->redirectToRoute('motInterdit_admin');
        }
        return $this->render("BonPlanBundle:Admin:MotInterdit.html.twig",array('motsInterdits'=>$motsInterdits,'form'=>$form->createView()));
    }




    public function ajouterMotInterditAction(Request $request)
    {
        $motInterdit= new MotInterdit();
        $Form=$this->createForm(MotInterditType::class,$motInterdit);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($motInterdit);
            $entityManager->flush();

            return $this->render('BonPlanBundle:Admin:MotInterdit.html.twig');
        }

        return $this->render('CategorieBundle:Default:ajout.html.twig',array('form'=>$Form->createView()));

    }

    public function ModifierMotInterditAction(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $id=$request->get('id');
        $motInterdit=$entityManager->getRepository("BonPlanBundle:MotInterdit")->findOneBy(['id'=>$id]);
        $form=$this->createForm(MotInterditType::class,$motInterdit);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('motInterdit_admin');
        }
        return $this->render("CategorieBundle:motInterdit:modifierMot.html.twig",array('form'=>$form->createView()));
    }



    public function SupprimerMotInterditAction(Request $request)
    {
        $id=$request->get('id');
        $entityManager=$this->getDoctrine()->getManager();
        $motInterdit=$entityManager->getRepository("BonPlanBundle:MotInterdit")->find($id);
        $entityManager->remove($motInterdit);
        $entityManager->flush();

        return $this->redirectToRoute('motInterdit_admin');
    }
}
