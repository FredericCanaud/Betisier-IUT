<?php
class Division
{

	  /////////////////// Attributs //////////////////

    private $divnum;
    private $divnom;

		///////////////// Constructeurs ////////////////

    public function __construct($valeurs = array())
    {
        if (!empty($valeurs))
        //print_r ($valeurs);
        $this->affecte($valeurs);
    }
    public function affecte($donnees)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            switch ($attribut)
            {
                case 'div_num':
                    $this->setDivNum($valeur);
                break;
                case 'div_nom':
                    $this->setDivNom($valeur);
                break;
            }
        }
    }

		////////////////// Getters ////////////////////

    public function getDivNum()
    {
        return $this->divnum;
    }
    public function getDivNom()
    {
        return $this->divnom;
    }

		////////////////// Setters ////////////////////

		public function setDivNum($divnum)
    {
        $this->divnum = $divnum;
    }
    public function setDivNom($divnom)
    {
        $this->divnom = $divnom;
    }
}
?>
