<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BadgeBonPlaneur
 *
 * @ORM\Table(name="badge_bon_planeur")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\BadgeRepository")
 */
class BadgeBonPlaneur
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
     *
     * @ORM\ManyToOne(targetEntity="Badge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_badge", referencedColumnName="id")
     * })
     */
    private $idBadge;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_bon_planeur", referencedColumnName="id")
     * })
     */
    private $loginBonPlaneur;


}

