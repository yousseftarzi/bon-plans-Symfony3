<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MoyenneCritere
 *
 * @ORM\Table(name="moyenne_critere")
 * @ORM\Entity
 */
class MoyenneCritere
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
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=true)
     */
    private $note;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_professionnel", referencedColumnName="id")
     * })
     */
    private $idProfessionnel;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Critere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_critere", referencedColumnName="id")
     * })
     */
    private $idCritere;

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

    /**
     * @return mixed
     */
    public function getIdCritere()
    {
        return $this->idCritere;
    }

    /**
     * @param mixed $idCritere
     */
    public function setIdCritere($idCritere)
    {
        $this->idCritere = $idCritere;
    }


}

