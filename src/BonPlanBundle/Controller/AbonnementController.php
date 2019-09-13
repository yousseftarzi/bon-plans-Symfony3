<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 13/04/2018
 * Time: 07:39
 */

namespace BonPlanBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbonnementController extends Controller
{

    public function deleteAction(Request $request,$id)
    {


        $u=$this->getDoctrine()->getRepository("BonPlanBundle:Abonnement")->find($id);
        $this->getDoctrine()->getManager()->remove($u);
        $this->getDoctrine()->getManager()->flush();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $arrData = ['output' => 'ok'];

            return new JsonResponse($arrData);
        }
        return $this->render('BonPlanBundle::Home.html.twig');
    }



    public function AjoutAbonnementAction()
    {
        $b=new BonPlan();
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find("1");


        $b->setLoginAuteur($u);

        $this->getDoctrine()->getManager()->persist($b);
        $this->getDoctrine()->getManager()->flush();
        return $this->render('BonPlanBundle::BonPlanDetails.html.twig');
    }



    /////ajax////////
    /**
     * @Route("/")
     */
    public function ajaxAction(Request $request) {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $username = $user->getUsername();
            $userid  = $user->getId();}
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find($userid);
        $s=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find(1);


        $a = new Abonnement();

        $a->setIdAbonne($u);
        $a->setIdsource($s);
        $this->getDoctrine()->getManager()->persist($a);
        $this->getDoctrine()->getManager()->flush();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $arrData = ['output' => 'ok'];

            return new JsonResponse($arrData);
        }
        return $this->render('BonPlanBundle::Home.html.twig');


    }



    /////afficher abonneee
    public function afficher_AboAction(){

        $iduser= $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        $abonnement = $this->getDoctrine()->getRepository('BonPlanBundle:Abonnement')->findBy(['IdAbonne'=>$iduser]);



        return $this->render('BonPlanBundle:Abonnement:afficherAbo.html.twig',array('Abonnements'=>$abonnement));


    }

    public function statsAction()
    {

        $newColumnChart = new ColumnChart();
        $val=111;
        $em    = $this->get('doctrine.orm.entity_manager');
        $tb = $em->createQuery("SELECT a ,COUNT (a.IdAbonne)as x FROM BonPlanBundle:Abonnement a GROUP BY a.IdAbonne");
//        $user= $this->getUser();
        $tbex=$tb->getResult();
        //  $query = $em->createQuery("SELECT COUNT (a.id) FROM BonPlanBundle:Abonnement a WHERE a.IdAbonne =:user ")
        //   ->setParameter(':user',$user);
        $x=1;
        $abnm1=new Abonnement();
        $count1=0;
        $abnm2=new Abonnement();
        $count2=0;

        $abnm3=new Abonnement();
        $count3=0;

        foreach ($tbex as $l){
            if($x==1){$abnm1=$l[0]->getIdAbonne()->getUsername();$count1=$l['x'];}
            if($x==2){$abnm2=$l[0]->getIdAbonne()->getUsername();$count2=$l['x'];}
            if($x==3){$abnm3=$l[0]->getIdAbonne()->getUsername();$count3=$l['x'];}
            $x++;
        }

        $newColumnChart->getData()->setArrayToDataTable(
            [
                ['Nom', 'Abonnement'],
                [$abnm1,(integer)$count1],
                [$abnm2,(integer) $count2],
                [$abnm3,(integer)$count3],


            ]
        );


        return $this->render('BonPlanBundle:Abonnement:Stats.html.twig', array(

            'newColumnChart' => $newColumnChart,"test"=>$tbex

        ));}



    ////effacer reclamation

    public function deleteAboAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modeles=$em->find(Reclamation::class,$id);
        $em->remove($modeles);
        $em->flush();
        return $this->redirectToRoute('affre');
    }

}