<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteBonPlan
 *
 * @ORM\Table(name="note_bon_plan")
 * @ORM\Entity
 */
class NoteBonPlan
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
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_bon_planeur", referencedColumnName="id")
     * })
     */
    private $loginBonPlaneur;

    /**
     *
     * @ORM\ManyToOne(targetEntity="BonPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bon_plan", referencedColumnName="id")
     * })
     */
    private $idBonPlan;

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
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param float $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getLoginBonPlaneur()
    {
        return $this->loginBonPlaneur;
    }

    /**
     * @param mixed $loginBonPlaneur
     */
    public function setLoginBonPlaneur($loginBonPlaneur)
    {
        $this->loginBonPlaneur = $loginBonPlaneur;
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


}

