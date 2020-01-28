<?php
class MotManager {

		////////////////// Constructeur ////////////////

    private $db;
    private $motsInterdits;
    public function __construct($db) {
        $this->db = $db;
        // Tout les mots sont chargés a la création du manager. Il y à un unique SELECT
        $this->motsInterdits = array();
        $sql = 'SELECT * from mot';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
            $this->motsInterdits[] = $citation->mot_interdit;
        }
        $requete->closeCursor();
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne un booléen vrai ou faux
		// suivant si le mot passé en paramètre est
		// interdit ou non
		//
		////////////////////////////////////////////////

    public function estUnMotCorrect($mot) {
        foreach ($this->motsInterdits as $motInterdit) {
            if ($mot == $motInterdit) {
                return false;
            }
        }
        return true;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne un booléen vrai ou faux
		// suivant si la phrase passée en paramètre
		// contient des mots interdits ou non
		//
		////////////////////////////////////////////////

    public function estUnePhraseCorrecte($phrase) {
        if (empty($phrase)) {
            return true;
        }
        return count($this->getAllMotsInterdits($phrase)) == 0;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne une phrase avec des mots
		// interdits convertis en --- pour avoir une
		// phrase correcte
		//
		////////////////////////////////////////////////

    public function getPhraseCorrecte($phrase) {
        $mots = explode(" ", $phrase);
        $newPhrase = [];
        $i = 1;
        foreach ($mots as $mot) {
            $lowMot = strtolower($mot);
            if (!$this->estUnMotCorrect($lowMot)) {
                $tiret = "";
                for ($i = 1;$i <= strlen($mot);$i = $i + 1) {
                    $tiret = $tiret . "-";
                }
                $nouvellePhrase[] = $tiret;
            } else {
                $nouvellePhrase[] = $mot;
            }
        }
        return implode(" ", $newPhrase);
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la liste des mots
		// interdits contenus dans une phrase
		//
		////////////////////////////////////////////////

    public function getAllMotsInterdits($phrase) {
        $motsInterdits = [];
        $phrase = strtolower($phrase);
        $mots = explode(" ", $phrase);
        foreach ($mots as $mot) {
            if (!$this->estUnMotCorrect($mot)) {
                $motsInterdits[] = $mot;
            }
        }
        return $motsInterdits;
    }
}
?>
