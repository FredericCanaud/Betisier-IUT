<?php
class Vote
{

		/////////////////// Attributs //////////////////

    private $citnum;
    private $pernum;
    private $votvaleur;

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
                case 'cit_num':
                    $this->setCitNum($valeur);
                break;
                case 'per_num':
                    $this->setPerNum($valeur);
                break;
                case 'vot_valeur':
                    $this->setVotValeur($valeur);
                break;
            }
        }
    }

		////////////////// Getters ////////////////////

    public function getCitNum()
    {
        return $this->citnum;
    }
    public function getPerNum()
    {
        return $this->pernum;
    }
    public function getVotValeur()
    {
        return $this->votvaleur;
    }

		////////////////// Setters ////////////////////

    public function setCitNum($citnum)
    {
        $this->citnum = $citnum;
    }
    public function setPerNum($pernum)
    {
        $this->pernum = $pernum;
    }
    public function setVotValeur($votvaleur)
    {
        $this->votvaleur = $votvaleur;
    }

}
?>
