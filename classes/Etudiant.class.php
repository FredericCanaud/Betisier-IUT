<?php
class Etudiant
{

    /////////////////// Attributs //////////////////

    private $pernum;
    private $depnum;
    private $divnum;
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
                case 'dep_num':
                    $this->setDepNum($valeur);
                break;
                case 'div_num':
                    $this->setDivNum($valeur);
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
    public function getDepNum()
    {
        return $this->depnum;
    }
    public function getDivNum()
    {
        return $this->divnum;
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
    public function setDepNum($depnum)
    {
        $this->depnum = $depnum;
    }
    public function setDivNum($divnum)
    {
        $this->divnum = $divnum;
    }
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }
}
?>
