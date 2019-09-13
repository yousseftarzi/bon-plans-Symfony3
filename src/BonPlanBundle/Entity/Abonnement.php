<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity
 */
class Abonnement
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
     * @ORM\JoinColumn(name="IdAbonne", referencedColumnName="id")
     */
    private $IdAbonne;

    /**
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="Idsource", referencedColumnName="id")
     */
    private $Idsource;

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
    public function getIdAbonne()
    {
        return $this->IdAbonne;
    }

    /**
     * @param mixed $IdAbonne
     */
    public function setIdAbonne($IdAbonne)
    {
        $this->IdAbonne = $IdAbonne;
    }

    /**
     * @return mixed
     */
    public function getIdsource()
    {
        return $this->Idsource;
    }

    /**
     * @param mixed $Idsource
     */
    public function setIdsource($Idsource)
    {
        $this->Idsource = $Idsource;
    }


}

