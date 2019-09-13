<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_bon_planeur", referencedColumnName="id")
     */
    private $idBonPlaneur;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_professionnel", referencedColumnName="id")
     */
    private $idProfessionnel;

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
    public function getIdProfessionnel()
    {
        return $this->idProfessionnel;
    }

    /**
     * @param mixed $idProfessionnel
     */
    public function setIdProfessionnel($idProfessionnel)
    {
        $this->idProfessionnel = $idProfessionnel;
    }

    public function __toString()
    {
        return "id".$this->id."Bon planeur".$this->idBonPlaneur."Professionnel".$this->idProfessionnel;
    }


}

