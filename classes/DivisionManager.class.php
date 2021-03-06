<?php
class DivisionManager {

	  ////////////////// Constructeur ////////////////

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les divisons de la BD
		//
		////////////////////////////////////////////////

    public function getAllDivisions() {
        $listeDivisions = array();
        $sql = 'SELECT div_num, div_nom FROM division';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($division = $requete->fetch(PDO::FETCH_OBJ)) $listeDivisions[] = new Division($division);
        $requete->closeCursor();
        return $listeDivisions;
    }
}
?>
