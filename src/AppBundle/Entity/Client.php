<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client
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
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     */
    private $mdp;

    /**
     * @var boolean
     *
     * @ORM\Column(name="administrateur", type="boolean", nullable=false)
     */
    private $administrateur;


    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setNom($nom){
        $this->nom = $nom;

        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setMail($mail){
        $this->mail = $mail;

        return $this;
    }

    public function getMail() {
        return $this->mail;
    }


    public function setMdp($mdp){
        $this->mdp = $mdp;

        return $this;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setAdministrateur($administrateur){
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getAdministrateur() {
        return $this->administrateur;
    }
}

