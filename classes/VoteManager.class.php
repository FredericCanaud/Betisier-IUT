<?php
class VoteManager {

	  ////////////////// Constructeur ////////////////

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les notes de la BD
		//
		////////////////////////////////////////////////

    public function getAllNotes() {
        $listeNotes = array();
        $sql = 'SELECT vot_valeur FROM vote';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($note = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeNotes[] = new Note($note);
        }
        $requete->closeCursor();
        return $listeNotes;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la moyenne des notes
		// d'une citation de la BD
		//
		////////////////////////////////////////////////

    public function getMoyNotes($citnum) {
        $sql = 'SELECT AVG(vot_valeur) AS moyenne FROM vote
              WHERE cit_num = :citnum';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':citnum', $citnum);
        $requete->execute();
        $moyNotes = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $moyNotes->moyenne;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne une liste des votes
		// d'une citation de la BD.
		//
		////////////////////////////////////////////////

    public function getVotesFromCitation($citnum) {
        $listeVotes = array();
        $sql = "SELECT cit_num, per_num, vot_valeur FROM vote WHERE cit_num = :citnum";
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':citnum', $citnum);
        $requete->execute();
        while ($vote = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeVotes[] = new Vote($vote);
        }
        $requete->closeCursor();
        return $listeVotes;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne la note du citation
		// d'une personne, en fonction du numéro de la
		// citation et de la personne passée en paramètre
		//
		////////////////////////////////////////////////

    public function getNoteCitationPersonne($citnum, $pernum) {
        $sql = 'SELECT cit_num AS num FROM vote
              WHERE cit_num = :citnum AND per_num = :pernum';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':citnum', $citnum);
        $requete->bindValue(':pernum', $pernum);
        $requete->execute();
        $note = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return !empty($note->num);
    }

		////////////////////////////////////////////////
		//
		// Fonction qui ajoute une note à une citation
		// dans la table Vote
		//
		////////////////////////////////////////////////

    public function ajouterNote($citnum, $pernum, $note) {
        $sql = 'INSERT INTO vote (cit_num, per_num, vot_valeur) VALUES (:citnum, :pernum, :note)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':citnum', $citnum);
        $requete->bindValue(':pernum', $pernum);
        $requete->bindValue(':note', $note);
        $requete->execute();
        $requete->closeCursor();
    }
}
?>
