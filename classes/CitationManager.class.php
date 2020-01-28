<?php
class CitationManager {

		////////////////// Constructeur ////////////////

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les citations valides de la BD
		// Elle prend en compte le fait que la citation soit validée (cit_valide + cit_date_valide)
		// Elle retourne la liste des citations présentes
		//
		////////////////////////////////////////////////

    public function getAllCitations() {
        $listeCitations = array();
        $sql = 'SELECT c.cit_num, c.per_num, cit_libelle, cit_date, AVG(vot_valeur) as moy_note FROM citation c
            JOIN vote v ON v.cit_num = c.cit_num
            WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL
            GROUP BY per_num, cit_libelle, cit_date';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($citation = $requete->fetch(PDO::FETCH_OBJ)) $listeCitations[] = new Citation($citation);
        $requete->closeCursor();
        return $listeCitations;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne tous les citations non validées de la BD
		// Elle prend en compte le fait que la citation soit  non validée (cit_valide)
		// Elle retourne la liste des citations non validées présentes
		//
		////////////////////////////////////////////////

    public function getAllNewCitations() {
        $listeCitations = array();
        $sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_valide = 0';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeCitations[] = new Citation($citation, $this->getVotes($citation->cit_num));
        }
        $requete->closeCursor();
        return $listeCitations;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne une citation en fonction de son numéro
		//
		////////////////////////////////////////////////
    public function getCitation($citnum) {
        $sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_num=:citnum';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':citnum', $citnum);
        $requete->execute();
        $citation = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        $nouvelleCitation = new Citation($citation);
        return $nouvelleCitation;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui retourne les votes d'une citation
		// à partir de la table Vote
		//
		////////////////////////////////////////////////

    private function getVotes($citnum) {
        $pdo = new Mypdo();
        $voteManager = new VoteManager($pdo);
        $votesCitation = $voteManager->getVotesFromCitation($citnum);
        return $votesCitation;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui insère une citation dans la BD en
		// fonction de ses attributs
		//
		////////////////////////////////////////////////

    public function ajouterCitation($pernum, $numetu, $citdate, $citlib) {
        $requete = $this->db->prepare("INSERT INTO citation (per_num, per_num_etu, cit_libelle, cit_date) VALUES (:pernum, :numetu, :libelle, :citdate);");
        $requete->bindValue(':pernum', $pernum);
        $requete->bindValue(':numetu', $numetu);
        $requete->bindValue(':citdate', $citdate);
        $requete->bindValue(':libelle', $citlib);
        $retour = $requete->execute();
        $requete->closeCursor();
        return $retour;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui supprime une citation dans la BD
		// passée en paramètre, en supprimant d'abord les
		// dépendances avec la table vote
		//
		////////////////////////////////////////////////

    public function supprimerCitation($citation) {

        $sql = 'DELETE FROM vote WHERE cit_num = :cit_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':cit_num', $citation->getCitNum());
        $requete->execute();
        $requete->closeCursor();

        $sql = 'DELETE FROM citation WHERE cit_num = :cit_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':cit_num', $citation->getCitNum());
        $retour = $requete->execute();
        $requete->closeCursor();
        return $retour;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui valide une citation dans la BD
		// passée en paramètre avec un login, qui changera
		// per_num_valide par le numero de la personne
		//
		////////////////////////////////////////////////

    public function valider($citation, $login) {

        $pdo = new Mypdo();
        $personneManager = new PersonneManager($pdo);

        $sql = 'UPDATE citation SET cit_valide = 1 WHERE cit_num = :cit_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':cit_num', $citation->getCitNum());
        $requete->execute();
        $requete->closeCursor();

        $sql = 'UPDATE citation SET cit_date_valide = CURDATE()  WHERE cit_num = :cit_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':cit_num', $citation->getCitNum());
        $requete->execute();
        $requete->closeCursor();

        $sql = 'UPDATE citation SET per_num_valide = :pernum WHERE cit_num = :cit_num';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':cit_num', $citation->getCitNum());
        $requete->bindValue(':per_num', $personneManager->getNumLogin($login));
        $retour = $requete->execute();
        $requete->closeCursor();

        return $retour;
    }

		////////////////////////////////////////////////
		//
		// Fonction qui recherche une citation dans la BD
		// en fonction d'un, de deux ou des trois paramètres
		// de recherche (per_num,cit_date ou la note)
		//
		////////////////////////////////////////////////

    public function getFiltredCitation($pernum, $citdate, $note) {
        $listeCitations = array();

        if (($pernum != NULL) && ($citdate == NULL) && ($note == NULL)) {
            $sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation
					  WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL
						AND per_num=:per_num';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':per_num', $pernum);

        } elseif (($pernum == NULL) && ($citdate != NULL) && ($note == NULL)) {
            $sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation
					  WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL
				   	AND cit_date=:cit_date';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':cit_date', $citdate);

        } elseif (($pernum == NULL) && ($citdate == NULL) && ($note != NULL)) {
            $sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c
					  INNER JOIN vote v ON v.cit_num = c.cit_num
					  WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL
					  AND v.vot_valeur=:note';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':note', $note);

        } elseif (($pernum != NULL) && ($citdate != NULL) && ($note == NULL)) {
            $sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation
					  WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL
					  AND per_num=:per_num
					  AND cit_date=:cit_date';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':per_num', $pernum);
            $requete->bindValue(':cit_date', $citdate);

        } elseif (($pernum == NULL) && ($citdate != NULL) && ($note != NULL)) {
            $sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c
					  INNER JOIN vote v ON v.cit_num = c.cit_num
					  WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL
					  AND v.vot_valeur=:note
					  AND c.cit_date=:cit_date';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':note', $note);
            $requete->bindValue(':cit_date', $citdate);

        } elseif (($pernum != NULL) && ($citdate == NULL) && ($note != NULL)) {
            $sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c
					  INNER JOIN vote v ON v.cit_num = c.cit_num
					  WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL
					  AND v.vot_valeur=:note
					  AND c.per_num=:per_num';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':note', $note);
            $requete->bindValue(':per_num', $pernum);

        } elseif (($pernum != NULL) && ($citdate != NULL) && ($note != NULL)) {
            $sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c
					  INNER JOIN vote v ON v.cit_num = c.cit_num
					  WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL
					  AND v.vot_valeur=:note
					  AND c.per_num=:per_num
					  AND c.cit_date=:cit_date';

            $requete = $this->db->prepare($sql);
            $requete->bindValue(':note', $note);
            $requete->bindValue(':per_num', $pernum);
            $requete->bindValue(':cit_date', $citdate);
        }
        $requete->execute();
        while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeCitations[] = new Citation($citation, $this->getVotes($citation->cit_num));
        }
        $requete->closeCursor();

        return $listeCitations;
    }
}
?>
