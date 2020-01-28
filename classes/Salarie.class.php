<?php
class Salarie
{

    /////////////////// Attributs //////////////////

    private $pernum;
    private $saltelprof;
    private $fonnum;
    private $personne;

    ///////////////// Constructeurs ////////////////

    public function __construct($valeurs = array() , $personne)
    {
        if (!empty($valeurs)) $this->affecte($valeurs, $personne);
    }

    public function affecte($donnees, $personne)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            switch ($attribut)
            {
                case 'per_num':
                    $this->setPerNum($valeur);
                break;
                case 'sal_telprof':
                    $this->setSalTelprof($valeur);
                break;
                case 'fon_num':
                    $this->setFonNum($valeur);
                break;
            }
        }
        $this->setPersonne($personne);
    }

    ////////////////// Getters ////////////////////

    public function getPerNum()
    {
        return $this->pernum;
    }
    public function getSalTelprof()
    {
        return $this->saltelprof;
    }
    public function getFonNum()
    {
        return $this->fonnum;
    }
    public function getPersonne()
    {
        return $this->personne;
    }

    ////////////////// Setters ////////////////////

    public function setPerNum($pernum)
    {
        $this->pernum = $pernum;
    }
    public function setSalTelprof($saltelprof)
    {
        $this->saltelprof = $saltelprof;
    }
    public function setFonNum($fonnum)
    {
        $this->fonnum = $fonnum;
    }
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }

}
?>
