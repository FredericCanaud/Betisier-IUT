<?php
class PersonneManager {

	  ////////////////// Constructeur ////////////////

    private $dbo;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les personnes de la BD
		//
		////////////////////////////////////////////////

    public function getAllPersonnes() {
        $listePersonnes = array();
        $sql = 'SELECT per_num, per_nom, per_prenom FROM personne';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($personne = $requete->fetch(PDO::FETCH_OBJ)) $listePersonnes[] = new Personne($personne);
        $requete->closeCursor();

        return $listePersonnes;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la personne associée au
		// numéro de la personne passé en paramètre
		//
		////////////////////////////////////////////////

    public function getPersonne($per_num) {
        $sql = 'SELECT per_nom, per_prenom, per_tel, per_mail FROM personne
						WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num, PDO::PARAM_INT);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $personne = new Personne($ligne);

        return $personne;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne le login de la personne
		// associée au mot de passe de la personne
		//
		////////////////////////////////////////////////

    public function getLogin($per_login, $per_pwd) {
        $sql = 'SELECT per_login FROM personne
						WHERE per_login = :per_login
						AND per_pwd = :per_pwd';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_login', $per_login);
        $requete->bindValue(':per_pwd', $per_pwd);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();

        return $ligne;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne le numéro de la personne
		// associée au login de la personne
		//
		////////////////////////////////////////////////

    public function getNumLogin($login) {
        $sql = 'SELECT per_num FROM personne WHERE per_login=:per_login';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_login', $login);
        $requete->execute();
        $resultat = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();

        return $resultat->per_num;
    }

		////////////////////////////////////////////////
		//
		// Fonction booléenne qui retourne vrai si la personne
		// est un administrateur ou non
		//
		////////////////////////////////////////////////

    public function isAdmin($per_login) {
        $sql = 'SELECT per_admin FROM personne WHERE per_login = :per_login';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_login', $per_login);
        $requete->execute();
        $ligne = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();

        return $ligne->per_admin;
    }

		////////////////////////////////////////////////
		//
		// Fonction booléenne qui retourne vrai si la personne
		// est un étudiant ou non
		//
		////////////////////////////////////////////////

    public function isEtudiant($per_num) {
        $sql = 'SELECT per_num FROM etudiant WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num);
        $requete->execute();
        $ligne = $requete->fetch();

        return $ligne;
    }

		////////////////////////////////////////////////
		//
		// Fonction booléenne qui retourne vrai si la personne
		// est un salarié ou non
		//
		////////////////////////////////////////////////

    public function isSalarie($per_num) {
        $sql = 'SELECT per_num FROM salarie WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $per_num);
        $requete->execute();
        $ligne = $requete->fetch();

        return $ligne;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui ajoute une personne dans la BD
		//
		////////////////////////////////////////////////

    public function ajouterPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd) {
        $sql = 'INSERT INTO personne(per_nom,per_prenom,per_tel,per_mail,per_admin,per_login,per_pwd)
						    VALUES (:per_nom,:per_prenom,:per_tel,:per_mail,0,:per_login,:per_pwd)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_nom', $per_nom);
        $requete->bindValue(':per_prenom', $per_prenom);
        $requete->bindValue(':per_tel', $per_tel);
        $requete->bindValue(':per_mail', $per_mail);
        $requete->bindValue(':per_login', $per_login);
        $requete->bindValue(':per_pwd', $per_pwd);
        $requete->execute();
    }

		////////////////////////////////////////////////
		//
		// Fonction qui modifie une personne dans la BD
		//
		////////////////////////////////////////////////

    public function modifierPersonne($personne) {
        $sql = 'UPDATE personne SET per_nom=:per_nom, per_prenom=:per_prenom, per_tel=:per_tel, per_mail=:per_mail, per_login=:per_login
			 	        WHERE per_num = :per_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':per_num', $personne->getPerNum());
        $requete->bindValue(':per_nom', $personne->getPerNom());
        $requete->bindValue(':per_prenom', $personne->getPerPrenom());
        $requete->bindValue(':per_tel', $personne->getPerTel());
        $requete->bindValue(':per_mail', $personne->getPerMail());
        $requete->bindValue(':per_login', $personne->getPerLogin());
        $retour = $requete->execute();
        $requete->closeCursor();
        return $retour;
    }

    ////////////////////////////////////////////////
    //
    // Fonction qui supprime une personne dans la BD
    // On supprime préalablement les dépendances avec
    // les tables vote, citation, puis etudiant ou
    // salarie suivant le status de la personne
    //
    ////////////////////////////////////////////////

    public function supprimerPersonne($personne){
			  $per_num = $personne->getPerNum();

			  $sql = 'DELETE FROM vote WHERE cit_num = :per_num';
			  $requete = $this->db->prepare($sql);
			  $requete->bindValue(':per_num', $per_num);
			  $requete->execute();
		 	  $requete->closeCursor();

			  $sql = 'DELETE FROM citation WHERE cit_num = :per_num';
			  $requete = $this->db->prepare($sql);
			  $requete->bindValue(':per_num', $per_num);
			  $requete->execute();
			  $requete->closeCursor();

			  $sql = 'DELETE FROM etudiant WHERE per_num = :per_num';
			  $requete = $this->db->prepare($sql);
			  $requete->bindValue(':per_num', $per_num);
			  $requete->execute();
			  $requete->closeCursor();

			  $sql = 'DELETE FROM salarie WHERE per_num = :per_num';
			  $requete = $this->db->prepare($sql);
			  $requete->bindValue(':per_num', $per_num);
			  $requete->execute();
			  $requete->closeCursor();

			  $sql = 'DELETE FROM personne WHERE per_num = :per_num';
			  $requete = $this->db->prepare($sql);
			  $requete->bindValue(':per_num', $per_num);
			  $retour = $requete->execute();
			  $requete->closeCursor();

			  return $retour;
		}
}
?>
