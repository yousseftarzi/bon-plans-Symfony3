<?php

namespace BonPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{


    /**
     * @link http://fullcalendar.io/docs/event_data/events_json_feed/
     *
     * @param Request $request
     *
     * @return Response
     */
    public function loadAction(Request $request)
    {


        return $this->render('reservation/calander.html.twig');

    }
    /**
     * @\Symfony\Component\Routing\Annotation\Route("/cal")
     *
     */
   public function DataEventAction(){

        $em = $this->getDoctrine()->getManager();
        $event=$em->getRepository('BonPlanBundle:Reservation')->findAll();
        $events = array();

        foreach($event as $row){
            $e = array();
            $e['title']=$row->getIdBonPlan()->getTitre();
            $e['url']="/Ponblan11/web/app_dev.php/profileR/".$row->getId();
            $e['start'] = date($row->getStartdate()->format('Y-m-d'));
            array_push($events, $e);
        }
        return new JsonResponse($events);
    }
}
