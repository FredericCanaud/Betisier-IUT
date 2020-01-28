<?php
class DepartementManager {

    ////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les départements de la BD
		//
		////////////////////////////////////////////////

    public function getAllDepartements() {
        $listeDepartements = array();
        $sql = 'SELECT dep_num, dep_nom, vil_num FROM departement';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($departement = $requete->fetch(PDO::FETCH_OBJ)) $listeDepartements[] = new Departement($departement);
        $requete->closeCursor();

        return $listeDepartements;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la ville associée au
		// numéro du département passé en paramètre
		//
		////////////////////////////////////////////////

    public function getVille($dep_num) {
        $sql = 'SELECT vil_nom FROM ville v
						    JOIN departement d ON d.vil_num = v.vil_num
						    WHERE d.dep_num = :dep_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':dep_num', $dep_num, PDO::PARAM_INT);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);

        $nomVille = new Ville($ligne);
        return $nomVille;
    }
}
?>
