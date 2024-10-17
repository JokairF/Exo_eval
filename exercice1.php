<?php
abstract class Vehicule
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;

    // On oblige les classes filles à définir les méthodes abstracts
    abstract public function demarrer();
    abstract function eteindre();
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    // Méthode magique toString
    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Voiture extends Vehicule
{
    private static $nombreVoiture = 0;

    public function __construct($vitesseMax)
    {
        self::$nombreVoiture++;
        $this->vitesseMax = $vitesseMax;
    }

    private $freinStationnement = FALSE;

    public static function getNombreVoiture()
    {
        return self::$nombreVoiture;
    }

    public function activerFreinStationnement()
    {
        if ($this->vitesse == 0) {
            $this->freinStationnement = TRUE;
        }
    }

    public function desactiverFreinStationnement()
    {
        $this->freinStationnement = FALSE;
    }

    public function demarrer()
    {
        if ($this->freinStationnement) {
            echo "Impossible de démarrer, le frein de stationnement est activé.<br />";
            return;
        }
        $this->demarrer = TRUE;
    }

    public function eteindre()
    {
        $this->demarrer = FALSE;
        $this->vitesse = 0;
    }

    /**
     * decelerer
     *
     * @param mixed $vitesse
     * @return void
     */
    public function decelerer($vitesse)
    {
        if ($this->demarrer) {
            // Limite la décélération 20 km/h
            $vitesse = min($vitesse, 20);
            $this->vitesse -= $vitesse;
            if ($this->vitesse < 0) {
                $this->vitesse = 0;
            }
        }
    }

    public function accelerer($vitesse)
    {
        if ($this->demarrer) {
            $maxIncrease = ($this->vitesse == 0) ? max($vitesse, 1) : max($this->vitesse * 0.3, 1); // 30% de la vitesse actuelle ou vitesse initiale si à l'arrêt
            if ($vitesse > $maxIncrease) {
                $vitesse = $maxIncrease;
            }
            $this->vitesse += $vitesse;
            if ($this->vitesse > $this->vitesseMax) {
                $this->vitesse = $this->vitesseMax;
            }
            if ($this->vitesse == 0 && $vitesse > 10) {
                $this->vitesse = 10;
            }
        }
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "Vitesse actuelle : " . $this->vitesse . " km/h<br />";
        $chaine .= "Vitesse maximale : " . $this->vitesseMax . " km/h<br />";
        return $chaine;
    }
}


$veh1 = new Voiture(110);
$veh1->demarrer();
$veh1->accelerer(40);
echo $veh1;
$veh1->accelerer(40);
echo $veh1;
$veh1->accelerer(12);
$veh1->accelerer(40);
echo $veh1;
$veh1->accelerer(40);
$veh1->decelerer(120);
echo $veh1;

$veh2 = new Voiture(180);
echo $veh2;

echo "############################ <br/>";
echo "Nombre de voiture instanciée : " . Voiture::getNombreVoiture() . "<br/>";
