<?php
class Fonction
{

    /////////////////// Attributs //////////////////

    private $fonnum;
    private $fonlibelle;

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
                case 'fon_num':
                    $this->setFonNum($valeur);
                break;
                case 'fon_libelle':
                    $this->setFonLib($valeur);
                break;
            }
        }
    }

    ////////////////// Getters ////////////////////

    public function getFonNum()
    {
        return $this->fonnum;
    }
    public function getFonLib()
    {
        return $this->fonlibelle;
    }

    ////////////////// Setters ////////////////////

    public function setFonNum($fonnum)
    {
        $this->fonnum = $fonnum;
    }
    public function setFonLib($fonlibelle)
    {
        $this->fonlibelle = $fonlibelle;
    }

}
?>
