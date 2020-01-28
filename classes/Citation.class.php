<?php
class Citation
{

    ////////////////////// Attributs ////////////////

    private $citnum;
    private $pernum;
    private $pernumetu;
    private $citlib;
    private $citdate;
    private $moynote;

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
                case 'cit_num':
                    $this->setCitNum($valeur);
                break;
                case 'per_num':
                    $this->setPerNum($valeur);
                break;
                case 'per_num_etu':
                    $this->setPerNumEtu($valeur);
                break;
                case 'cit_libelle':
                    $this->setCitLib($valeur);
                break;
                case 'cit_date':
                    $this->setCitDate($valeur);
                break;
                case 'moy_note':
                    $this->setMoyNote($valeur);
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
    public function getPerNumEtu()
    {
        return $this->pernumetu;
    }
    public function getCitLib()
    {
        return $this->citlib;
    }
    public function getCitDate()
    {
        return $this->citdate;
    }
    public function getMoyNote()
    {
        return $this->moynote;
    }

    ////////////////////// Setters //////////////////////

    public function setCitNum($citnum)
    {
        $this->citnum = $citnum;
    }
    public function setPerNum($pernum)
    {
        $this->pernum = $pernum;
    }
    public function setPerNumEtu($pernumetu)
    {
        $this->pernumetu = $pernumetu;
    }
    public function setCitLib($citlib)
    {
        $this->citlib = $citlib;
    }
    public function setCitDate($citdate)
    {
        $this->citdate = $citdate;
    }
    public function setMoyNote($moynote)
    {
        $this->moynote = $moynote;
    }
}
?>
