<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotesCriteres
 *
 * @ORM\Table(name="notes_criteres")
 * @ORM\Entity
 */
class NotesCriteres
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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Critere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_critere", referencedColumnName="id")
     * })
     */
    private $idCritere;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Evaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evaluation", referencedColumnName="id")
     * })
     */
    private $idEvaluation;

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
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
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

    /**
     * @return mixed
     */
    public function getIdEvaluation()
    {
        return $this->idEvaluation;
    }

    /**
     * @param mixed $idEvaluation
     */
    public function setIdEvaluation($idEvaluation)
    {
        $this->idEvaluation = $idEvaluation;
    }



}

