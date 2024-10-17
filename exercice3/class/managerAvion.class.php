<?php
require_once('class/Avion.class.php');

class AvionManger
{

    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function add(Avion $avion)
    {
        $query = $this->_db->prepare('INSERT INTO avions (nom, pays, annee, constructeur) VALUES (:nom, :pays, :anne, :constructeur)');
        $query->bindValue(':nom', $avion->getNom());
        $query->bindValue(':pays', $avion->getPays());
        $query->bindValue(':annee', $avion->getAnnee());
        $query->bindValue(':constructeur', $avion->getConstructeur());
        $query->execute();
    }
}
