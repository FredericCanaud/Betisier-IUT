<?php
class SalarieManager {

  	////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les salariés de la BD
		//
		////////////////////////////////////////////////

    public function getAllSalaries() {
        $listeSalaries = array();
        $sql = 'SELECT per_num, sal_telprof, fon_num FROM salarie';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);
        while ($salarie = $requete->fetch(PDO::FETCH_OBJ)) $listeSalaries[] = new Salarie($salarie,$personneManager->getPersonne($salarie->per_num));
        $requete->closeCursor();
        return $listeSalaries;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne le salarié auquel
		// correspond le numéro de personne passé
		// en paramètre
		//
		////////////////////////////////////////////////

		public function getSalarie($per_num) {
        $sql = 'SELECT per_num, sal_telprof, fon_num FROM salarie
           WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num, PDO::PARAM_INT);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);
        $salarie = new Salarie($ligne, $personneManager->getPersonne($per_num));
        return $salarie;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la fonction auquel
		// correspond le numéro de personne du salarié
		// passé en paramètre
		//
		////////////////////////////////////////////////

		public function getFonction($per_num) {
				$sql = 'SELECT f.fon_num, fon_libelle FROM fonction f
					 JOIN salarie s ON f.fon_num = s.fon_num
					 WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num, PDO::PARAM_INT);
				$requete->execute();
				$ligne = $requete->fetch(PDO::FETCH_OBJ);
				$nomFonction = new Fonction($ligne);
				return $nomFonction;
		}

		////////////////////////////////////////////////
		//
		// Fonction qui ajoute un étudiant dans la BD
		// à partir de son login, de son téléphone
		// professionnel et de sa fonction passés en paramètre
		// On récupère d'abord son numéro de personne
		// avec son login avant l'ajout
		//
		////////////////////////////////////////////////

		public function ajouterSalarie($per_login, $sal_telprof, $fon_num) {
				$sql = 'SELECT per_num FROM personne WHERE per_login = :per_login';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_login', $per_login);
				$requete->execute();
				$ligne = $requete->fetch(PDO::FETCH_OBJ);
				$requete->closeCursor();

				$per_num = $ligne->per_num;

				$sql = 'INSERT INTO salarie(per_num,sal_telprof,fon_num)
						    VALUES (:per_num,:sal_telprof,:fon_num)';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$requete->bindValue(':sal_telprof', $sal_telprof);
				$requete->bindValue(':fon_num', $fon_num);
				$requete->execute();
		}

		////////////////////////////////////////////////
		//
		// Fonction qui modifie un salarié dans la BD,
		// en modifiant d'abord sa personne
		//
		////////////////////////////////////////////////

    public function modifierSalarie($salarie) {
        $personne = $salarie->getPersonne();
        if ($this->modifierPersonneSalarie($personne)) {
            $sql = 'UPDATE salarie SET sal_telprof=:sal_telprof, fon_num=:fon_num WHERE per_num=:per_num';
            $requete = $this->db->prepare($sql);
            $requete->bindValue(':per_num', $personne->getPerNum());
            $requete->bindValue(':sal_telprof', $salarie->getSalTelProf());
            $requete->bindValue(':fon_num', $salarie->getFonNum());
            $retour = $requete->execute();
            $requete->closeCursor();
            return $retour;
        }
        return false;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui appelle la modification d'un
		// salarié en tant que personne
		//
		////////////////////////////////////////////////

    public function modifierPersonneSalarie($personne) {
        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);
        $retour = $personneManager->modifierPersonne($personne);
        return $retour;
    }

}
?>
