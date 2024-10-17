<?php

class Avion
{
    private $nom;
    private $pays;
    private $annee;
    private $constructeur;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPays()
    {
        return $this->pays;
    }

    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    public function getAnnee()
    {
        return $this->annee;
    }

    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    public function getConstructeur()
    {
        return $this->constructeur;
    }

    public function setConstructeur($constructeur)
    {
        $this->constructeur = $constructeur;
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
