<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){
  ?>
  <h1>Supprimer une citation enregistrée</h1>
  <?php
  $citationManager = new CitationManager($pdo);
  $personneManager = new PersonneManager($pdo);
  if(empty($_GET['idCit']) && !isset($_SESSION['citation'])){
  	$citations = $citationManager -> getAllCitations();
  ?>

  <p>Actuellement <?php echo count($citations) ?> citation(s) sont enregistrée(s)</p>
  <div class="tab">

  <table id="tableSupCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>
</div>
  	<?php
  		foreach ($citations as $citation){
        $numCit = $citation->getCitNum()?>
  	<tr>
      <td><?php echo $personneManager->getPersonne($citation->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($citation->getPerNum())->getPerNom();?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyNote();?></td>
      <td><a href="index.php?page=12&idCit=<?php echo $numCit?>"><img class='icone' src='image/erreur.png' alt='Supprimer Citation'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

<?php
}else{

	$citationManager = new CitationManager($pdo);

  if (isset($_POST['valider'])) {

    $citationManager->supprimerCitation($_SESSION['citation']);
    $enseignant = $personneManager->getPersonne($_SESSION["citation"]->getPerNum())->getPerNom();
    ?>
    <p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation <?php echo $enseignant; ?> a été supprimée</p>
    <p>Redirection automatique dans 2 secondes...</p>
    <?php
    unset($_SESSION['citation']);
    header("Refresh: 2;URL=index.php?page=12");

  } elseif (isset($_POST['annuler'])) {
    ?>
    <p> Suppression annulée ! </p>
    <p>Redirection automatique dans 2 secondes...</p>
    <?php
    unset($_SESSION['citation']);
    header("Refresh: 2;URL=index.php?page=12");

  } else{
    $_SESSION['citation'] = $citationManager->getCitation($_GET['idCit']); ?>

    <form action="index.php?page=12" id="supprCitation" method="post">

      <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette citation ?</label>
      </br>
    	<input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">

    </form>

<?php }
  }
}else{
  ?>
  <p>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>
  <p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  <?php
  header("Refresh: 3;URL=index.php");
}
?>
