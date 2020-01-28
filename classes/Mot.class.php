<?php
class Mot
{
    /////////////////// Attributs //////////////////

    private $motinterdit;

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
                case 'mot_interdit':
                    $this->setMotInterdit($valeur);
                break;
            }
        }
    }

    ////////////////// Getters ////////////////////

    public function getMotInterdit()
    {
        return $this->motinterdit;
    }

    ////////////////// Setters ////////////////////

    public function setMotInterdit($motinterdit)
    {
        $this->motinterdit = $motinterdit;
    }
}
?>
