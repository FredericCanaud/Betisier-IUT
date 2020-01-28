<?php
class Ville
{

		/////////////////// Attributs //////////////////

    private $vilnum;
    private $vilnom;

		///////////////// Constructeurs ////////////////

    public function __construct($valeurs = array())
    {
        if (!empty($valeurs)) $this->affecte($valeurs);
    }
    public function affecte($donnees)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            switch ($attribut)
            {
                case 'vil_num':
                    $this->setVilNum($valeur);
                break;
                case 'vil_nom':
                    $this->setVilNom($valeur);
                break;
            }
        }
    }

		////////////////// Getters ////////////////////

    public function getVilNum()
    {
        return $this->vilnum;
    }
    public function setVilNum($vilnum)
    {
        $this->vilnum = $vilnum;
    }

		////////////////// Setters ////////////////////

    public function getVilNom()
    {
        return $this->vilnom;
    }
    public function setVilNom($vilnom)
    {
        $this->vilnom = $vilnom;
    }
}
?>
