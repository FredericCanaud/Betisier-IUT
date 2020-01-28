<?php
class Departement
{

    /////////////////// Attributs ///////////////////

    private $depnum;
    private $depnom;
    private $vilnum;

    ////////////////// Constructeurs ////////////////

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
                case 'dep_num':
                    $this->setDepNum($valeur);
                break;
                case 'dep_nom':
                    $this->setDepNom($valeur);
                break;
                case 'vil_num':
                    $this->setVilNum($valeur);
                break;
            }
        }
    }

    ////////////////// Getters ////////////////////

    public function getDepNum()
    {
        return $this->depnum;
    }
    public function getDepNom()
    {
        return $this->depnom;
    }
    public function getVilNum()
    {
        return $this->vilnum;
    }

    ////////////////////// Setters //////////////////////

    public function setDepNum($depnum)
    {
        $this->depnum = $depnum;
    }
    public function setDepNom($depnom)
    {
        $this->depnom = $depnom;
    }
    public function setVilNum($vilnum)
    {
        $this->vilnum = $vilnum;
    }

}
?>
