<?php
/**
 * Created by PhpStorm.
 * User: youssefc
 * Date: 08/04/2018
 * Time: 16:01
 */

namespace BonPlanBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Reclamation
 *
 * @ORM\Table(name="Reclamation")
 * @ORM\Entity
 */


class Reclamation
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
     * @ORM\JoinColumn(name="Idsource", referencedColumnName="id")
     */
    private $Idsource;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=100, nullable=true)
     */
    private $message;

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

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }



}