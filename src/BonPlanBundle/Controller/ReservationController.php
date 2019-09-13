<?php
/**
 * Created by PhpStorm.
 * User: Brigade Rouge
 * Date: 02/04/2018
 * Time: 22:44
 */

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\BonPlan;
use BonPlanBundle\Entity\Utilisateur;
use BonPlanBundle\Entity\Reservation;
use BonPlanBundle\Form\ReservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Twilio\Rest\Client;

//require __DIR__  . '/twilio-php-master/Twilio/autoload.php';

class ReservationController extends Controller
{
    /**
     *
     * @Route("/add",name="addreservation")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function addAction (Request $req,$id){



        $em=$this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $bonplan=$em->getRepository('BonPlanBundle:BonPlan')->find($id);
        $bonplan->getId();
        $reservation->setIdBonPlan( $bonplan);
        $iduser=$em->getRepository('BonPlanBundle:Utilisateur')->find($this->getUser()->getId());
        $bp=$em->getRepository('BonPlanBundle:BonPlan')->find($id);
        $reservation->setIdBonPlaneur($iduser);
        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($req);
        $formview = $form->createView();

        if ($form->isSubmitted()){
           // $user = $this->get('security.token_storage')->getToken()->getUser();

           // $reservation->setIdBonPlaneur($user);
            $bp= $this->getDoctrine()->getRepository('BonPlanBundle:BonPlan')->find($bp);
            $bp->setNbreCoupon($bp->getNbreCoupon()-$reservation->getNbrCoupon());
            $em->persist($reservation);
            $em->flush();
           /* $sid = 'AC0f27d7073bfcba612f894ab6ac500b0b';
            $token = 'd1e0257ed34b26054d8e15b2401f8f00';
            $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                '+21628872773',
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+19388008894',
                    // the body of the text message you'd like to send
                    'body' => "Hey! the event is canceled!"));*/


            return $this->render('@BonPlan/Home.html.twig',array('form'=>$formview,'BonPlans'=>$bonplan,'reservations'=>$reservation));



        }


        return $this->render('reservation/reservationadd.html.twig',array('form'=>$formview,'bp'=>$bonplan,'reservations'=>$reservation));
    }



    public function xdddAction(){

        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->createQuery('SELECT bp , count(bp.idBonPlan)as x FROM BonPlanBundle:Reservation bp GROUP BY bp.idBonPlan ORDER BY x DESC ');
       $x= $query->getResult();
       return $this->render('@BonPlan/Deals.html.twig',array('test'=>$x));
    }


    public function listReservationAction(){


        $iduser= $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        $reservations = $this->getDoctrine()->getRepository('BonPlanBundle:Reservation')->findBy(['idBonPlaneur'=> $iduser]);


        foreach($reservations as $res)
        {$datenow=new \DateTime();
            $d1=$datenow->format('Y-m-d');
            $d2=$res->getStartdate()->format('Y-m-d');

            if($d1>$d2)
            {
                $em=$this->getDoctrine()->getManager();
                $em->remove($res);
                $em->flush();
            }

        }
        $reservations = $this->getDoctrine()->getRepository('BonPlanBundle:Reservation')->findBy(['idBonPlaneur'=> $iduser]);
        return $this->render(':reservation:reservationlist.html.twig',array('reservations'=>$reservations));


    }

    public function listReservationaAction(){

        $em=$this->getDoctrine()->getManager();

        $reservations = $this->getDoctrine()->getRepository('BonPlanBundle:Reservation')->findAll();


        return $this->render(':reservation:adminreservation.html.twig',array('reservations'=>$reservations));


    }

    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("BonPlanBundle:Reservation")->find($id);
        $bonplan=$em->getRepository('BonPlanBundle:BonPlan')->find($id);
        $bonplan->getId();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('aff');
        }

        return $this->render("reservation/reservationmodifier.html.twig",array('form'=>$form->createView(),'bp'=>$bonplan,'reservations'=>$reservation));
    }


    public function aupdateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("BonPlanBundle:Reservation")->find($id);
        $bonplan=$em->getRepository('BonPlanBundle:BonPlan')->find($id);
        $bonplan->getId();

        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('reservation_affiche');
        }

        return $this->render("reservation/adminmodifier.html.twig",array('form'=>$form->createView()));
    }



    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("BonPlanBundle:Reservation")->find($id);

        $em->remove($reservation);

            $em->flush();
        $iduser= $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user= $this->getDoctrine()->getRepository('BonPlanBundle:Utilisateur')->find($iduser);
        $user->setNbsupp($user->getNbsupp()+1);
        $em->flush();
            return $this->redirectToRoute('aff');



    }

    public function reserverAction(Request $request ,$id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('BonPlanBundle:Utilisateur')->find($user)->getId();


        $id=(int)$id;

        $existe = $em->getRepository('BonPlanBundle:Reservation')->reservation($usr, $id);
        if ($existe == null) {

            $sql = "INSERT INTO `reservation`(`id_bon_planeur`, `evenement_reservation`, `date_reservation`) VALUES ($usr,$id,CURRENT_DATE())";
            $em->getConnection()->prepare($sql)->execute();
            /* rakka7 il path */
            return $this->redirectToRoute('profilEvent', array('id' => $id));


        } elseif ($existe !== null) {

            $sql = "DELETE FROM `allforkids`.`reservation` WHERE `reservation`.`evenement_reservation` = ".$id." AND `reservation`.`reservation_user` =".$usr;
            $em->getConnection()->prepare($sql)->execute();

            echo "test";
            var_dump("test");
            return $this->redirectToRoute('profilEvent', array('id' => $id));
        }

    }
    public function RenderEventAction(){
        $em=$this->getDoctrine()->getManager();
        $events = $em->getRepository("BonPlanBundle:Reservation")->findAll();
        return $this->json($events);
    }


    public function indexRAction(Reservation $id)
    {

        $em=$this->getDoctrine();
        $reser=$em->getRepository("BonPlanBundle:Reservation")->find($id);

        return $this->render('reservation/reservationprofile.html.twig',array('reservation'=>$reser));


    }

}