<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=100, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="BonPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bon_plan", referencedColumnName="id")
     * })
     */
    private $idBonPlan;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_auteur", referencedColumnName="id")
     * })
     */
    private $idAuteur;

    /**
     * Commentaire constructor.
     *
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }


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
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
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
     * @return mixed
     */
    public function getIdAuteur()
    {
        return $this->idAuteur;
    }

    /**
     * @param mixed $idAuteur
     */
    public function setIdAuteur($idAuteur)
    {
        $this->idAuteur = $idAuteur;
    }



}

