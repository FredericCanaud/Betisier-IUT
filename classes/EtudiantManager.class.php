<?php
class EtudiantManager {

	  ////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les étudiants de la BD
		//
		////////////////////////////////////////////////

    public function getAllEtudiants() {
        $listeEtudiants = array();
        $sql = 'SELECT per_num, dep_num, div_num FROM etudiant';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($etudiant = $requete->fetch(PDO::FETCH_OBJ)) $listeEtudiants[] = new Etudiant($etudiant);
        $requete->closeCursor();
        return $listeEtudiants;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne l'étudiant auquel
		// correspond le numéro de personne passé
		// en paramètre
		//
		////////////////////////////////////////////////

    public function getEtudiant($per_num) {
        $sql = 'SELECT per_num, dep_num, div_num FROM etudiant
                WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num, PDO::PARAM_INT);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);
        $etudiant = new Etudiant($ligne, $personneManager->getPersonne($per_num));
        return $etudiant;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne le département auquel
		// correspond le numéro de personne de l'étudiant
		// passé en paramètre
		//
		////////////////////////////////////////////////

    public function getDepartement($per_num) {
        $sql = 'SELECT d.dep_num, dep_nom FROM etudiant e
                JOIN departement d ON d.dep_num = e.dep_num
                WHERE e.per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num, PDO::PARAM_INT);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $nomDepartement = new Departement($ligne);
        return $nomDepartement;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui ajoute un étudiant dans la BD
		// à partir de son login, de son département et
		// de sa division passés en paramètre
		// On récupère d'abord son numéro de personne
		// avec son login avant l'ajout
		//
		////////////////////////////////////////////////

    public function ajouterEtudiant($per_login, $dep_num, $div_num) {
        $sql = 'SELECT per_num FROM personne WHERE per_login = :per_login';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_login', $per_login);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();

        $per_num = $ligne->per_num;

        $sql = 'INSERT INTO etudiant(per_num,dep_num,div_num)
						    VALUES (:per_num,:dep_num,:div_num)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num);
        $requete->bindValue(':dep_num', $dep_num);
        $requete->bindValue(':div_num', $div_num);
        $requete->execute();
    }

		////////////////////////////////////////////////
		//
		// Fonction qui modifie un étudiant dans la BD,
		// en modifiant d'abord sa personne
		//
		////////////////////////////////////////////////

    public function modifierEtudiant($etudiant) {
        $personne = $etudiant->getPersonne();
        if ($this->modifierPersonneEtudiant($personne)) {
            $sql = 'UPDATE etudiant SET dep_num=:dep_num, div_num=:div_num WHERE per_num=:per_num';
            $requete = $this->db->prepare($sql);
            $requete->bindValue(':per_num', $personne->getPerNum());
            $requete->bindValue(':dep_num', $etudiant->getDepNum());
            $requete->bindValue(':div_num', $etudiant->getDivNum());
            $retour = $requete->execute();
            $requete->closeCursor();
            return $retour;
        }
        return false;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui appelle la modification d'un
		// étudiant en tant que personne
		//
		////////////////////////////////////////////////

    public function modifierPersonneEtudiant($personne) {
        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);
        $retour = $personneManager->modifierPersonne($personne);
        return $retour;
    }
}
?>
