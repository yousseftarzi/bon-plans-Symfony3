<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historique
 *
 * @ORM\Table(name="historique")
 * @ORM\Entity
 */
class Historique
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
     * @var array
     *
     * @ORM\Column(name="action", type="simple_array", nullable=false)
     */
    private $action;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_professionnel", referencedColumnName="id")
     * })
     */
    private $loginProfessionnel;

    /**
     * @var \Utilisateur
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


}

