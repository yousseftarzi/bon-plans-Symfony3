<?php

namespace BonPlanBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * BonPlan
 *
 * @ORM\Table(name="bon_plan")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\BonPlanRepository")
 * @Vich\Uploadable
 */
class BonPlan
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
     * @ORM\Column(name="titre", type="string", length=100, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="5000k")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @Assert\File(maxSize="5000k")
     */
    public $file;

    public function getWebPath()
    {

        return null ===$this->imageName?null:$this->getUploadDir.'/'.$this->imageName;
    }
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../web/../../'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        return 'img';
    }
    public function uploadProfilPicture()
    {
        if($this->file != null && $this->file != "")
        {$this->file->move($this->getUploadRootDir(),$this->file->getClientOriginalName());
            $this->imageName=$this->file->getClientOriginalName();

            $this->file=null;}

    }



    /**
     * @var array
     *
     * @ORM\Column(name="type_auteur", type="simple_array", nullable=true)
     */
    private $typeAuteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_coupon", type="integer", nullable=true)
     */
    private $nbreCoupon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=true)
     */
    private $note;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     * })
     */
    private $idCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="login_auteur", referencedColumnName="id")
     */
    private $loginAuteur;

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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $image
     */
    public function setImageName($image)
    {
        $this->imageName = $image;
    }

    /**
     * @return array
     */
    public function getTypeAuteur()
    {
        return $this->typeAuteur;
    }

    /**
     * @param array $typeAuteur
     */
    public function setTypeAuteur($typeAuteur)
    {
        $this->typeAuteur = $typeAuteur;
    }

    /**
     * @return int
     */
    public function getNbreCoupon()
    {
        return $this->nbreCoupon;
    }

    /**
     * @param int $nbreCoupon
     */
    public function setNbreCoupon($nbreCoupon)
    {
        $this->nbreCoupon = $nbreCoupon;
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
     * @return \Categorie
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * @param \Categorie $idCategorie
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    /**
     * @return mixed
     */
    public function getLoginAuteur()
    {
        return $this->loginAuteur;
    }

    /**
     * @param mixed $loginAuteur
     */
    public function setLoginAuteur($loginAuteur)
    {
        $this->loginAuteur = $loginAuteur;
    }

       /**
        * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
        * of 'UploadedFile' is injected into this setter to trigger the  update. If this
        * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
        * must be able to accept an instance of 'File' as the bundle will inject one here
        * during Doctrine hydration.
        *
        * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
        *
        */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function  __toString()
    {
        return $this->titre;
    }


}

