<?php

namespace BonPlanBundle\Controller;
use BonPlanBundle\Entity\Commentaire;
use BonPlanBundle\Entity\NoteBonPlan;
use BonPlanBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Http\Client\HttpClient;
use Ivory\GoogleMap\Service\Place\Detail\PlaceDetailService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\InfoWindowType;
use BonPlanBundle\Entity\BonPlan;
use BonPlanBundle\Entity\Utilisateur;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderPlaceIdRequest;
use Ivory\GoogleMap\Service\Place\Autocomplete\PlaceAutocompleteService;
use Ivory\GoogleMap\Service\Place\Detail\Request\PlaceDetailRequest;
use Symfony\Component\HttpFoundation\Request;
use Ivory\GoogleMap\Service\Place\Autocomplete\Request\PlaceAutocompleteRequest;


use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;

use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;

use Ivory\GoogleMap\Control\ControlPosition;
use Ivory\GoogleMap\Control\MapTypeControl;
use Ivory\GoogleMap\Control\MapTypeControlStyle;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Base\Size;
use Ivory\GoogleMap\Event\MouseEvent;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $x=array();

        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(array(),array('id'=>'DESC'),6);

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$u));


    }
    public function DealsAction(Request $request)
    {
        $x=array();

        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findAll();

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM BonPlanBundle:BonPlan a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );


        return $this->render('BonPlanBundle::Deals.html.twig',array("BonPlans"=>$pagination));
    }
    public function listBonPlanneurAction()
    {


        $u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->findByRole("Bon Planeur");

        return $this->render('BonPlanBundle::bplanneur.html.twig',array("u"=>$u,"id"=>$this->getUser()->getId()));
    }
    public function profileAction(Request $r)
    {$b=new BonPlan();

        $marker = new Marker(
            new Coordinate(),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => true]
        );

        $marker->setVariable('marker');
        $map=new Map();
        $map->setVariable('map');
        $map->setAutoZoom(true);

// Sets the center
        $map->setCenter(new Coordinate(36.8189700, 10.1657900));

// Sets the zoom
        $map->setMapOption('zoom', 3);

        $map->getOverlayManager()->addMarker($marker);






        $map->setMapOption('mapTypeId', MapTypeId::TERRAIN);
/////////////////////////////////

        $infoWindow = new InfoWindow('content', InfoWindowType::INFO_BOX, new Coordinate());

        $infoWindow->setVariable('info_window');
        $infoWindow->setContent('<p>Default content</p>');
        $infoWindow->setPosition(new Coordinate(36.8189700, 10.1657900));
        $infoWindow->setOpen(true);
        $infoWindow->setAutoOpen(true);
        $infoWindow->setOpenEvent(MouseEvent::CLICK);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOption('zIndex', 10);
        $map->getOverlayManager()->addInfoWindow($infoWindow);
        $marker->setInfoWindow($infoWindow);
        $marker->setPosition($infoWindow->getPosition());




        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->findOneBy(['id' => $user]);
        $f=$this->createForm("BonPlanBundle\Form\BonPlanType",$b);
        $f->handleRequest($r);



        if($f->isValid())
        {$time = new \DateTime();
            echo $time->format('H:i:s \O\n Y-m-d');
            $b->setLoginAuteur($u);
            $b->setDateCreation($time);
            $b->uploadProfilPicture();
            $this->getDoctrine()->getManager()->persist($b);
            $this->getDoctrine()->getManager()->flush();


            $Bonplans=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(['loginAuteur' => $user]);

            return $this->render('BonPlanBundle:Profile:profile.html.twig',array("form"=>$f->createView(),"MesBonPlans"=>$Bonplans,"id"=>$user,"map"=>$map));
        }

        $event = new Event(
            $marker->getVariable(),
            'click',
            'function(){alert("Marker clicked!");}',
            true
        );
        $event->setCapture(true);
        $map->getEventManager()->addEvent($event);
        $map->getEventManager()->addEventOnce($event);
        $map->setStaticOption('styles', [
            [
                'feature' => 'road.highway', // Optional
                'element' => 'geometry',     // Optional
                'rules'   => [               // Mandatory (at least one rule)
                    'color'      => '0xc280e9',
                    'visibility' => 'simplified',
                ],
            ],
            [
                'feature' => 'transit.line',
                'rules'   => [
                    'visibility' => 'simplified',
                    'color'      => '0xbababa',
                ]
            ],
        ]);
        $Bonplans=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(['loginAuteur' => $user]);



        return $this->render('BonPlanBundle:Profile:profile.html.twig',
            array("form"=>$f->createView(),"MesBonPlans"=>$Bonplans,"id"=>$user,"map"=>$map));
    }



    public function BonPlanDetailsAction()
    {
        return $this->render('BonPlanBundle::BonPlanDetails.html.twig');
    }
    public function AjoutBonPlanAction(Request $req)
    {$b=new BonPlan();
        //$u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->find("1");


//$b->setLoginAuteur($u);

//$this->getDoctrine()->getManager()->persist($b);
//$this->getDoctrine()->getManager()->flush();
        $b=new BonPlan();
        $f=$this->createForm("BonPlanBundle\Form\BonPlanType",$b);
        $f->handleRequest($req);

        $iduser = $this->container->get('session')->getId();
        $Bonplans=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->findBy(['loginAuteur' => $iduser]);
        return $this->render('BonPlanBundle:Profile:AjouterBonPlan.html.twig',array("form"=>$f->createView(),"MesBonPlans"=>$Bonplans));
    }


    public function rateAction(Request $request)
    {        $iduser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        if($request->isXmlHttpRequest()){
            //make something curious, get some unbelieveable data
            $rateold=$this->getDoctrine()->getRepository("BonPlanBundle:NoteBonPlan")->findOneBy(array('idBonPlan'=>$request->request->get('id'),"loginBonPlaneur"=>$iduser));
            if($rateold!=null)
            {$rateold->setNote($request->request->get('some_var_name'));
                $this->getDoctrine()->getManager()->flush();
            }else{
                $u=$this->getDoctrine()->getRepository("BonPlanBundle:Utilisateur")->findOneBy(['id' => $iduser]);
                $bonplan=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->find($request->request->get('id'));

                $rate=new NoteBonPlan();
                $rate->setNote($request->request->get('some_var_name'));
                $rate->setIdBonPlan($bonplan);
                $rate->setLoginBonPlaneur($u);
                $this->getDoctrine()->getManager()->persist($rate);
                $this->getDoctrine()->getManager()->flush();
            }

            $arrData = ['output' => 'here the result which will appear in div'];
            return new JsonResponse($arrData);
        }
        return "lll";


    }

    public function supprimerAction($id)
    {
        $bp=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->find($id);
        $res=$this->getDoctrine()->getRepository("BonPlanBundle:Reservation")->findBy(array("idBonPlan"=>$bp->getId()));
        foreach ($res as $l){
            $this->getDoctrine()->getManager()->remove($l);
            $this->getDoctrine()->getManager()->flush();}

        $this->getDoctrine()->getManager()->remove($bp);
        $this->getDoctrine()->getManager()->flush();


        return $this->redirectToRoute('Deals');

    }

    public function modifierbonplanAction(Request $r,$id)
    {
        $b=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->find($id);
        $f=$this->createForm("BonPlanBundle\Form\BonPlanType",$b);
        $f->handleRequest($r);



        if($f->isValid())
        {$time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $b->setDateCreation($time);
            $b->uploadProfilPicture();
            $this->getDoctrine()->getManager()->persist($b);
            $this->getDoctrine()->getManager()->flush();



            return $this->redirectToRoute('singleBonPlan',array("id"=>$id));
        }
        return $this->render('BonPlanBundle:Profile:modifier.html.twig',array("form"=>$f->createView()));

    }
    public function rechercherAction(Request $request)
    {$rate=100;
        $name="";
        $nbr=0;
        if($request->isMethod('POST')) {


            $rate=$request->get('smile');
            $name=$request->get('name');
            $nbr=(Integer)$request->get('myRange');

        }
        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->createQuery("SELECT rate,bp as x FROM BonPlanBundle:NoteBonPlan rate JOIN rate.idBonPlan bp WHERE (rate.note = $rate) AND (bp.nbreCoupon=$nbr)AND (bp.titre LIKE '%$name%')");
        $bps = $query->getResult();
        $bp=array();
        foreach ($bps as $b){
            $bp[]=$b->getIdBonPlan();
        }

        return $this->render('BonPlanBundle::Home.html.twig',array("BonPlans"=>$bp));
    }


    public function singleBonPlanAction(Request $request,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $motsInterdits=  $entityManager->getRepository("BonPlanBundle:MotInterdit")->findAll();
        /// /////////////
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
                    $this->get('session')->getFlashBag()->add('notice', 'Commentaire non autorisé à cause d\'un mot interdit!');
                    return $this->redirectToRoute('singleBonPlan', array('id' => $id));
                }
            }

            $commentaire->setIdAuteur($this->getUser());
            //$commentaire->setIdBonPlan($request->get('idBonPlan'));
            $commentaire->setIdBonPlan($entityManager->find("BonPlanBundle:BonPlan",$id));
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('singleBonPlan',array('id'=>$id));
        }


        $u=$this->getDoctrine()->getRepository("BonPlanBundle:BonPlan")->find($id);
        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->createQuery('SELECT bp , count(bp.idBonPlan)as x FROM BonPlanBundle:Reservation bp GROUP BY bp.idBonPlan ORDER BY x DESC ');
        $x= $query->getResult();
        $bp=array();
        $i=0;
        foreach ($x as $l)
        {
            if($i<3){
                $bp[]=$l;}
            $i++;
        }
        return $this->render('BonPlanBundle::singleBonPlan.html.twig',array("BonPlan"=>$u,"topBonPlan"=>$bp,'comments'=>$comments,
            'form' => $form->createView(),'currentUser'=>$this->getUser()));

    }

}
