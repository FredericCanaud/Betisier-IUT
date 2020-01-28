<?php
class VilleManager {

	  ////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les villes de la BD
		//
		////////////////////////////////////////////////

    public function getAllVilles() {
        $listeVilles = array();
        $sql = 'SELECT vil_num, vil_nom FROM ville';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($ville = $requete->fetch(PDO::FETCH_OBJ)) $listeVilles[] = new Ville($ville);
        $requete->closeCursor();

        return $listeVilles;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la ville associée au
		// numéro de la ville passé en paramètre
		//
		////////////////////////////////////////////////

    public function getVille($vil_num) {
        $sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num = :vil_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_num', $vil_num);
        $requete->execute();
        $ville = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        $ville = new Ville($ville);

        return $ville;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui ajoute une ville dans la BD avec
		// son nom passé en paramètre
		//
		////////////////////////////////////////////////

    public function ajouterVille($vil_nom) {
        $sql = 'INSERT INTO ville(vil_nom) VALUES (:vil_nom)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_nom', $vil_nom);
        $requete->execute();
    }

    ////////////////////////////////////////////////
    //
    // Fonction qui modifier une ville dans la BD avec
    // une nouvelle passée en paramètre
    //
    ////////////////////////////////////////////////

    public function modifierVille($ville){

				$sql = 'UPDATE ville SET vil_nom = :vil_nom WHERE vil_num = (:vil_num)';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':vil_nom', $ville->getVilNom());
				$requete->bindValue(':vil_num', $ville->getVilNum());
				$retour=$requete->execute();
				$requete->closeCursor();
        
				return $retour;

    }

		////////////////////////////////////////////////
		//
		// Fonction qui supprime une ville dans la BD
		// passée en paramètre.
		// On vérifie préalablement que la ville n'a pas
		// de dépendances avec les départements, et donc
		// avec les étudiants. Au quel cas, on n'effectuera
		// pas la suppression
		//
		////////////////////////////////////////////////

    public function supprimerVille($ville) {
        $sql = "SELECT COUNT(dep_num) AS villeDepartement FROM departement WHERE vil_num = :vil_num";
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_num', $ville->getVilNum());
        $requete->execute();
        $nbVillesDepartements = $requete->fetch(PDO::FETCH_OBJ);
        $nbVillesDepartements = $nbVillesDepartements->villeDepartement;
        $requete->closeCursor();
        if ($nbVillesDepartements == 0) {
            $sql = 'DELETE FROM ville WHERE vil_num = :vil_num';
            $requete = $this->db->prepare($sql);
            $requete->bindValue(':vil_num', $ville->getVilNum());
            $retour = $requete->execute();
            $requete->closeCursor();
            return $retour;
        } else {
            return false;
        }
    }
}
?>
