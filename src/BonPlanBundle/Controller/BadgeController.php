<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\BadgeBonPlaneur;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BonPlanBundle\Entity\Reservation;

class BadgeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function CheckBadgeReserverAction()
    {
        $badgeBonPlaneur=new BadgeBonPlaneur();
        $user=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find($this->getUser()->getId());

        $em=$this->getDoctrine()->getManager();
        $number=$em->getRepository("BonPlanBundle:BadgeBonPlaneur")->TotalReservation($this->getUser()->getId());
        echo $this->getUser()->getId();
        foreach ($number as $item) {
            $number=$item[0];
        }
        if ($number==1)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(1);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==50)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(2);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==100)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(3);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));

    }
    public function CheckBadgeEvaluerAction()
    {
        $badgeBonPlaneur=new BadgeBonPlaneur();
        $user=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find($this->getUser()->getId());

        $em=$this->getDoctrine()->getManager();
        $number=$em->getRepository("BonPlanBundle:BadgeBonPlaneur")->TotalEvaluation($this->getUser()->getId());
        foreach ($number as $item) {
            $number=$item[0];
        }
        if ($number==1)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(4);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==50)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(5);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==100)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(6);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));

    }

    public function CheckBadgeNoterAction()
    {
        $badgeBonPlaneur=new BadgeBonPlaneur();
        $user=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find($this->getUser()->getId());

        $em=$this->getDoctrine()->getManager();
        $number=$em->getRepository("BonPlanBundle:BadgeBonPlaneur")->TotalNote($this->getUser()->getId());
        foreach ($number as $item) {
            $number=$item[0];
        }
        if ($number==1)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(7);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==50)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(8);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==100)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(9);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));

    }

    public function CheckBadgePublierAction()
    {
        $badgeBonPlaneur=new BadgeBonPlaneur();
        $user=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find($this->getUser()->getId());

        $em=$this->getDoctrine()->getManager();
        $number=$em->getRepository("BonPlanBundle:BadgeBonPlaneur")->TotalPublication($this->getUser()->getId());
        foreach ($number as $item) {
            $number=$item[0];
        }
        if ($number==1)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(10);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==50)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(11);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        if ($number==100)
        {
            $badgeBonPlaneur->setLoginBonPlaneur($user);
            $badge=$this->getDoctrine()->getRepository("BonPlanBundle:Badge")->find(12);
            $badgeBonPlaneur->setIdBadge($badge);
            $user->setNbPoints($user->getNbPoints()+$badge->getNbPoints());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();


            $this->getDoctrine()->getManager()->persist($badgeBonPlaneur);
            $this->getDoctrine()->getManager()->flush();

        }
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));

    }








    public function RewardAction()
    {
        $date = new \DateTime();
        $date->modify('-1 hour');
        $em = $this->getDoctrine()->getManager();
        $recipient = $em->getRepository("BonPlanBundle:Utilisateur")->getRecipientValue();
        $bonPlaneur = $em->getRepository("BonPlanBundle:Utilisateur")->find($recipient[0]->getId());
        $bonPlanDisponible = $em->getRepository("BonPlanBundle:BonPlan")->getBonPlanDisponible($recipient[0]->getadresse());

        if (sizeof($bonPlanDisponible) > 0)
        {
            $rand = rand(0, sizeof($bonPlanDisponible) - 1);
            $bonPlan = $em->getRepository("BonPlanBundle:BonPlan")->find($bonPlanDisponible[$rand]->getId());

        }
        else
        {
            $bonPlanDisponible=$em->getRepository("BonPlanBundle:BonPlan")->getBonPlan();
            $rand= rand(0,sizeof($bonPlanDisponible)-1);
            $bonPlan=$em->getRepository("BonPlanBundle:BonPlan")->find($bonPlanDisponible[$rand]->getId());
        }

        $firstRanked=$recipient[0];
        for ($i=0; $i<count($recipient); $i++)
            if($firstRanked->getnbPoints()==$recipient[$i]->getnbPoints())
                $sameRecepients[]=$recipient[$i];
        $sameRecepients=array_values($sameRecepients);

        $finalRecipient=$sameRecepients[0];
        for($i=0; $i<count($sameRecepients)-1; $i++)
        {
            $date1 = $finalRecipient->getDateCreation();
            $date2 = $sameRecepients[$i+1]->getDateCreation();
            if($date1 > $date2)
                $finalRecipient = $sameRecepients[$i+1];
        }


        if (date_format($date,'d')=="13" and $recipient[0]->getrewarded()==0)
        {

            $reservation=$em->getRepository("BonPlanBundle:Reservation")->findBy(array('idBonPlaneur'=>$finalRecipient->getId(),'idBonPlan'=>$bonPlan->getId()));
            //var_dump($reservation);
            if (empty($reservation))
            {
                $reservation=new Reservation();
                $reservation->setIdBonPlaneur($finalRecipient);
                $reservation->setIdBonPlan($bonPlan);
                $date=new \DateTime();
                $reservation->setDateReservation($date);
                $reservation->setNbrCoupon(1);
                $em->persist($reservation);
                $em->flush();
            }
            else
            {

                //$reservation[0]->setIdBonPlaneur($finalRecipient);
                //$reservation[0]->setIdBonPlan($bonPlan);
                $date=new \DateTime();
                $reservation[0]->setDateReservation($date);
                $reservation[0]->setNbrCoupon($reservation[0]->getNbrCoupon()+1);

                $em->persist($reservation[0]);
                $em->flush();
            }

             $em->getRepository("BonPlanBundle:Utilisateur")->updateRewardValue(1);
            $em->getRepository("BonPlanBundle:Utilisateur")->initializePoints();
            $bonPlan->setNbreCoupon($bonPlan->getNbreCoupon()-1);
            $em->persist($bonPlan);
            $em->flush();

        }
        else
        {
            $em->getRepository("BonPlanBundle:Utilisateur")->updateRewardValue(0);

        }


        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));
    }

}
