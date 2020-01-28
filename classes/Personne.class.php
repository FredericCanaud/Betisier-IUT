<?php
class Personne
{

    /////////////////// Attributs //////////////////

    private $pernum;
    private $pernom;
    private $perprenom;
    private $pertel;
    private $permail;
    private $perlogin;
    private $perpwd;

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
                case 'per_num':
                    $this->setPerNum($valeur);
                break;
                case 'per_nom':
                    $this->setPerNom($valeur);
                break;
                case 'per_prenom':
                    $this->setPerPrenom($valeur);
                break;
                case 'per_tel':
                    $this->setPerTel($valeur);
                break;
                case 'per_mail':
                    $this->setPerMail($valeur);
                break;
                case 'per_login':
                    $this->setPerLogin($valeur);
                break;
                case 'per_pwd':
                    $this->setPerPwd($valeur);
                break;
            }
        }
    }

    ////////////////// Getters ////////////////////

    public function getPerNum()
    {
        return $this->pernum;
    }
    public function getPerNom()
    {
        return $this->pernom;
    }
    public function getPerPrenom()
    {
        return $this->perprenom;
    }
    public function getPerTel()
    {
        return $this->pertel;
    }
    public function getPerMail()
    {
        return $this->permail;
    }
    public function getPerLogin()
    {
        return $this->perlogin;
    }
    public function getPerPwd()
    {
        return $this->perpwd;
    }

    ////////////////// Setters ////////////////////

    public function setPerNum($pernum)
    {
        $this->pernum = $pernum;
    }
    public function setPerNom($pernom)
    {
        $this->pernom = $pernom;
    }
    public function setPerPrenom($perprenom)
    {
        $this->perprenom = $perprenom;
    }
    public function setPerTel($pertel)
    {
        $this->pertel = $pertel;
    }
    public function setPerMail($permail)
    {
        $this->permail = $permail;
    }
    public function setPerLogin($perlogin)
    {
        $this->perlogin = $perlogin;
    }
    public function setPerPwd($perpwd)
    {
        $this->perpwd = $perpwd;
    }

}
?>
