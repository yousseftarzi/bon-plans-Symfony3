<?php

namespace BonPlanBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\UtilisatRepository")
 */
class Utilisateur extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $usernameCanonical;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $emailCanonical;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * The salt to use for hashing.
     *
     * @var string
     */
    protected $salt;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @var \DateTime|null
     */
    protected $lastLogin;

    /**
     * Random string sent to the user email address in order to verify it.
     *
     * @var string|null
     */
    protected $confirmationToken;

    /**
     * @var \DateTime|null
     */
    protected $passwordRequestedAt;

    /**
     * @var GroupInterface[]|Collection
     */
    protected $groups;

    /**
     * @var array
     */
    protected $roles;



    /* ********************* */
    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=50, nullable=true)
     */
    private $login;



    /**
     * @var array
     *
     * @ORM\Column(name="role", type="simple_array", nullable=true)
     */
    private $role;

    /**
     * @var string
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_de_profil", type="string", length=50, nullable=true)
     */
    private $photoDeProfil;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_tel", type="integer", nullable=true)
     */
    private $numTel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_points", type="integer", nullable=true)
     */
    private $nbPoints;

    /**
     * @var float
     *
     * @ORM\Column(name="note_moyenne_professionnel", type="float", precision=10, scale=0, nullable=true)
     */
    private $noteMoyenneProfessionnel;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     * })
     */
    private $idCategorie;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_supp", type="integer", nullable=true)
     */
    private $nbsupp;




    /**
     * @var integer
     *
     * @ORM\Column(name="rewarded", type="integer", nullable=true)
     */
    private $rewarded;

    /**
     * @return int
     */
    public function getRewarded()
    {
        return $this->rewarded;
    }

    /**
     * @param int $rewarded
     */
    public function setRewarded($rewarded)
    {
        $this->rewarded = $rewarded;
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return array
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param array $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }



    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
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
    public function getPhotoDeProfil()
    {
        return $this->photoDeProfil;
    }

    /**
     * @param string $photoDeProfil
     */
    public function setPhotoDeProfil($photoDeProfil)
    {
        $this->photoDeProfil = $photoDeProfil;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param int $numTel
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
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
     * @return int
     */
    public function getNbPoints()
    {
        return $this->nbPoints;
    }

    /**
     * @param int $nbPoints
     */
    public function setNbPoints($nbPoints)
    {
        $this->nbPoints = $nbPoints;
    }

    /**
     * @return float
     */
    public function getNoteMoyenneProfessionnel()
    {
        return $this->noteMoyenneProfessionnel;
    }

    /**
     * @param float $noteMoyenneProfessionnel
     */
    public function setNoteMoyenneProfessionnel($noteMoyenneProfessionnel)
    {
        $this->noteMoyenneProfessionnel = $noteMoyenneProfessionnel;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string $usernameCanonical
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;
    }

    /**
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * @param string $emailCanonical
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }



    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return \DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }


    /**
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
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
     * @return int
     */
    public function getNbsupp()
    {
        return $this->nbsupp;
    }

    /**
     * @param int $nbsupp
     */
    public function setNbsupp($nbsupp)
    {
        $this->nbsupp = $nbsupp;
    }


}

