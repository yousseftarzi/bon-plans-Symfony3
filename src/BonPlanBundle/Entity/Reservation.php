<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="date", nullable=false)
     */
    private $dateReservation;

    /**
     * @var \integer
     *
     * @ORM\Column(name="nbrCoupon", type="integer", nullable=false)
     *
     * @Assert\Length(
     *     min=1 ,
     *     max=5 ,
     *     )
     */
    private $nbrCoupon;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bon_planeur", referencedColumnName="id")
     * })
     */
    private $idBonPlaneur;

    /**
     *
     * @Assert\Type(type="BonPlanBundle\Entity\BonPlan")
     * @ORM\OneToOne(targetEntity="BonPlanBundle\Entity\BonPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bon_plan", referencedColumnName="id")
     * })
     */
    private $idBonPlan;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate",type="date")
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate",type="date")
     */
    private $enddate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * @param \DateTime $dateReservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;
    }

    /**
     * @return int
     */
    public function getNbrCoupon()
    {
        return $this->nbrCoupon;
    }

    /**
     * @param int $nbrCoupon
     */
    public function setNbrCoupon($nbrCoupon)
    {
        $this->nbrCoupon = $nbrCoupon;
    }

    /**
     * @return mixed
     */
    public function getIdBonPlaneur()
    {
        return $this->idBonPlaneur;
    }

    /**
     * @param mixed $idBonPlaneur
     */
    public function setIdBonPlaneur($idBonPlaneur)
    {
        $this->idBonPlaneur = $idBonPlaneur;
    }

    /**
     * @return mixed
     */
    public function getIdBonPlan()
    {
        return $this->idBonPlan;
    }

    /**
     * @param mixed $idBonPlan
     */
    public function setIdBonPlan($idBonPlan)
    {
        $this->idBonPlan = $idBonPlan;
    }

    /**
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @param \DateTime $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    /**
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }


}

