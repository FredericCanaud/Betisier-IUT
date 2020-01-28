<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){
  $personneManager = new PersonneManager($pdo);
  ?>
  <h1>Supprimer une personne enregistrée</h1>
  <?php
  if(empty($_GET['idPersonne']) && !isset($_SESSION['personne'])){
		$personnes = $personneManager -> getAllPersonnes();
  ?>

  <p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

  <div class="tab">
	<table>
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Supprimer</th>
		</tr>

		<?php
			foreach ($personnes as $personne){
				$numPersonne = $personne->getPerNum();?>
		<tr>
			<td><?php echo $personne -> getPerNom();?></td>
			<td><?php echo $personne -> getPerPrenom();?></td>
			<td><a href="index.php?page=4&idPersonne=<?php echo $numPersonne?>"><img class='icone' src='image/erreur.png' alt='Supprimer personne'></a></td>
		</tr>

		<?php }	?>

	</table>
</div>
  <br />

<?php
}else{

  if (isset($_POST['valider'])) {
    $personneManager->supprimerPersonne($_SESSION['personne']);
    ?>
    <p><img class='icone' src='image/valid.png' alt='Supprimer personne valide'>La personne <?php echo $_SESSION['personne']->getPerPrenom();?> <?php echo $_SESSION['personne']->getPerNom()?> a été supprimée</p>
    <p>Redirection automatique dans trois secondes...</p>
    <?php
    unset($_SESSION['personne']);
    header("Refresh: 3;URL=index.php");

  } elseif (isset($_POST['annuler'])) {
    ?>
    <p> Suppression annulée ! </p>
    <p> Redirection automatique dans 3 secondes... </p>
    <?php
    unset($_SESSION['personne']);
    header("Refresh: 3;URL=index.php?page=4");

  } else{
    $_SESSION['personne'] = $personneManager->getPersonne($_GET['idPersonne']);
    $_SESSION['personne']->setPerNum($_GET['idPersonne']); ?>
    <form action="index.php?page=4" id="supprPers" method="post">

      <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette personne ?</label>
      </br>
    	<input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">

    </form>

<?php }
  }

}else{
  ?>
  <p><img class = 'icone' src='image/erreur.png' alt='ErreurConnexion'>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>
  <p>Redirection automatique dans 3 secondes...</p>";
  <?php
  header("Refresh: 3;URL=index.php");

}
?>
