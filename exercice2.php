<?php

abstract class Vehicule
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;

    // Constructor for Vehicule class
    public function __construct($vitesseMax)
    {
        $this->vitesseMax = $vitesseMax;
    }

    // On oblige les classes filles à définir les méthodes abstract
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    // Fonction pour démarrer le véhicule
    public function demarrer()
    {
        $this->demarrer = TRUE;
    }

    // Fonction pour éteindre le véhicule
    public function eteindre()
    {
        $this->demarrer = FALSE;
    }

    // Vérifier si le véhicule est démarré
    public function estDemarre()
    {
        return $this->demarrer;
    }

    // Vérifier si le véhicule est éteint
    public function estEteint()
    {
        return !$this->demarrer;
    }

    // Obtenir la vitesse actuelle
    public function getVitesse()
    {
        return $this->vitesse;
    }

    // Obtenir la vitesse maximale
    public function getVitesseMax()
    {
        return $this->vitesseMax;
    }

    // Méthode magique toString pour afficher un véhicule
    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}
class avion extends vehicule
{
    private $altitude = 0;
    private $altitudeMax = 40000;
    private $trainAtterrissageSorti = true;
    protected $vitesseMax = 2000;

    public function accelerer($vitesse)
    {
        if ($this->demarrer) {
            $this->vitesse += $vitesse;
            if ($this->vitesse > $this->vitesseMax) {
                $this->vitesse = $this->vitesseMax;
            }
            if ($this->vitesse >= 120 && $this->altitude == 0) {
                $this->altitude = 100;
            }
        }
    }

    public function decelerer($vitesse)
    {
        if ($this->demarrer) {
            $this->vitesse -= $vitesse;
            if ($this->vitesse < 0) {
                $this->vitesse = 0;
            }
        }
    }

    public function __construct($vitesseMax, $altitudeMax)
    {
        parent::__construct($vitesseMax);
        $this->altitudeMax = $altitudeMax;
    }

    public function decoller()
    {
        if ($this->demarrer && $this->vitesse >= 120) {
            $this->altitude = 100;
            if ($this->altitude > 300) {
                $this->trainAtterrissageSorti = false;
            }
        }
    }

    public function atterrir()
    {
        if ($this->trainAtterrissageSorti && $this->vitesse >= 80 && $this->vitesse <= 110 && $this->altitude >= 50 && $this->altitude <= 150) {
            $this->altitude = 0;
            $this->vitesse = 0;
            $this->trainAtterrissageSorti = true;
        }
    }

    public function monter($altitude)
    {
        if ($this->demarrer && $this->altitude > 0) {
            $this->altitude += $altitude;
            if ($this->altitude > $this->altitudeMax) {
                $this->altitude = $this->altitudeMax;
            }
            if ($this->altitude > 300) {
                $this->trainAtterrissageSorti = false;
            }
        }
    }

    public function descendre($altitude)
    {
        if ($this->demarrer && $this->altitude > 0) {
            $this->altitude -= $altitude;
            if ($this->altitude < 0) {
                $this->altitude = 0;
            }
        }
    }

    public function sortirTrainAtterrissage()
    {
        $this->trainAtterrissageSorti = true;
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "Altitude : " . $this->altitude . " m <br/>";
        $chaine .= "Altitude maximale : " . $this->altitudeMax . " m <br/>";
        $chaine .= "Train d'atterrissage sorti : " . ($this->trainAtterrissageSorti ? "Oui" : "Non") . " <br/>";
        return $chaine;
    }
}
function testVehicule()
{
    $vehicule = new class(150) extends Vehicule {
        public function accelerer($vitesse)
        {
            if ($this->demarrer) {
                $this->vitesse += $vitesse;
                if ($this->vitesse > $this->vitesseMax) {
                    $this->vitesse = $this->vitesseMax;
                }
            }
        }

        public function decelerer($vitesse)
        {
            if ($this->demarrer) {
                $this->vitesse -= $vitesse;
                if ($this->vitesse < 0) {
                    $this->vitesse = 0;
                }
            }
        }
    };

    $testResults = [
        'demarrer' => false,
        'accelerer' => false,
        'decelerer' => false,
        'eteindre' => false
    ];

    // Test démarrer
    $vehicule->demarrer();
    if ($vehicule->estDemarre() === TRUE) {
        $testResults['demarrer'] = true;
    }

    // Test accélération
    $vehicule->accelerer(50);
    if ($vehicule->getVitesse() === 50) {
        $testResults['accelerer'] = true;
    }

    // Test décélération
    $vehicule->decelerer(20);
    if ($vehicule->getVitesse() === 30) {
        $testResults['decelerer'] = true;
    }

    // Test éteindre
    $vehicule->eteindre();
    if ($vehicule->estEteint() === TRUE) {
        $testResults['eteindre'] = true;
    }

    return $testResults;
}

function testAvion()
{
    $avion = new avion(2000, 40000);

    $testResults = [
        'demarrer' => false,
        'accelerer' => false,
        'decoller' => false,
        'monter' => false,
        'descendre' => false,
        'atterrir' => false
    ];

    // Test démarrer
    $avion->demarrer();
    if ($avion->estDemarre() === TRUE) {
        $testResults['demarrer'] = true;
    }

    // Test accélération
    $avion->accelerer(500);
    if ($avion->getAltitude() === 100) {
        $testResults['accelerer'] = true;
    }

    // Test décollage
    $avion->decoller();
    if ($avion->getVitesse() === 500 && $avion->getAltitude() === 100) {
        $testResults['decoller'] = true;
    }

    // Test montée
    $avion->monter(1000);
    if ($avion->getAltitude() === 1100) {
        $testResults['monter'] = true;
    }

    // Test descente
    $avion->descendre(500);
    if ($avion->getAltitude() === 600) {
        $testResults['descendre'] = true;
    }

    // Test atterrissage
    $avion->sortirTrainAtterrissage();
    $avion->decelerer(400);
    $avion->descendre($avion->getAltitude() - 100);
    $avion->atterrir();
    if ($avion->getAltitude() === 0 && $avion->getVitesse() === 0) {
        $testResults['atterrir'] = true;
    }

    return $testResults;
}

try {
    $vehiculeResults = testVehicule();
    echo "Résultats des tests de véhicule :<br/>";
    foreach ($vehiculeResults as $test => $result) {
        echo ucfirst($test) . " : " . ($result ? "Réussi" : "Échoué") . "<br/>";
    }
} catch (AssertionError $e) {
    echo "Certains tests de véhicule ont échoué : " . $e->getMessage() . "<br/>";
}

try {
    $avionResults = testAvion();
    echo "Résultats des tests d'avion :<br/>";
    foreach ($avionResults as $test => $result) {
        echo ucfirst($test) . " : " . ($result ? "Réussi" : "Échoué") . "<br/>";
    }
} catch (AssertionError $e) {
    echo "Certains tests d'avion ont échoué : " . $e->getMessage() . "<br/>";
}
