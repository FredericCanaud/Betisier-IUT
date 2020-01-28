<?php
class FonctionManager {

	  ////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les fonctions de la BD
		//
		////////////////////////////////////////////////

    public function getAllFonctions() {
        $listefonctions = array();
        $sql = 'SELECT fon_num, fon_libelle FROM fonction';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($fonction = $requete->fetch(PDO::FETCH_OBJ)) $listeFonctions[] = new Fonction($fonction);
        $requete->closeCursor();
        return $listeFonctions;
    }
}
?>
