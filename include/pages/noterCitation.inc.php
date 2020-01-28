<?php
    $personneManager = new PersonneManager($pdo);
    $voteManager = new VoteManager($pdo);
    if(isset($_GET['citnum'])){
    $citManager = new CitationManager($pdo);
    $_SESSION['citation'] = $citManager->getCitation($_GET['citnum']);

?>
    <h1>Noter cette citation</h1>
    <h2>Veuillez attribuer une note à cette citation :</h2>
    <table id="noterCitation">
    	<tr>
    		<th>Nom de l'enseignant</th>
    		<th>Libellé</th>
    		<th>Date</th>
      </tr>

      <tr>
        <td><?php echo $personneManager->getPersonne($_SESSION['citation']->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($_SESSION['citation']->getPerNum())->getPerNom();?></td>
    		<td><?php echo $_SESSION['citation']->getCitLib();?></td>
    		<td><?php echo $_SESSION['citation']->getCitDate();?></td>
      </tr>
    </table></br>

    <form action="index.php?page=9" id="noterCitation" method="post">

      <label for="valeurNote">Note : </label>
      <input type="text" name="valeurNote" id="valeurNote"/></br>
      <input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">
    </form>

<?php

}elseif(!empty($_POST['valider'])){
    $valeur = $_POST['valeurNote'];
    $numeroCitation = $_SESSION['citation']->getCitNum();

    if(is_numeric($valeur) && $valeur >= 0 && $valeur <= 20){

      $numeroEtudiant = $personneManager->getNumLogin($_SESSION['login']);
      $valeur = round($valeur, 2);
      $retour = $voteManager->ajouterNote($numeroCitation, $numeroEtudiant, $valeur);
      $enseignant = $personneManager->getPersonne($_SESSION['citation']->getPerNum())->getPerNom(); ?>

      <p><img class='icone' src='image/valid.png' alt='Valider vote'>Vote pour la citation de <?php echo $enseignant ?> validée</p>
      <?php
      unset($_SESSION['citation']);
      header("Refresh: 3;URL=index.php");

    }else{
      unset($_SESSION['citation']); ?>

      <p><img class='icone' src='image/erreur.png' alt='Erreur valider vote'>Erreur : </p>
      <p>La note doit être comprise entre 0 et 20</p>
      <p>Redirection automatique dans 3 secondes...</p>

      <?php
      header("Refresh: 3;URL=index.php");
    }

  }elseif(!empty($_POST['annuler'])){
    unset($_SESSION['citation']);
    header("Refresh: 1;URL=index.php?page=6");
  }
?>
