<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageProfessionnel
 *
 * @ORM\Table(name="image_professionnel")
 * @ORM\Entity
 */
class ImageProfessionnel
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
     * @ORM\Column(name="nom_image", type="string", length=200, nullable=false)
     */
    private $nomImage;

    /**
     * @var string
     *
     * @ORM\Column(name="path_image", type="string", length=500, nullable=false)
     */
    private $pathImage;



}

