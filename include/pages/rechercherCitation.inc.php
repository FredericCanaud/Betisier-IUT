<?php
if(isset($_SESSION['estConnecte'])){
  $personneManager = new PersonneManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $listeSalaries = $salarieManager->getAllSalaries();
?>

<h1>Rechercher une citation</h1>

<form action="index.php?page=10" id="searchCitation" method="post">

  <label for="per_num">Enseignant : </label>
  <select name="per_num" id="per_num">
    <option value="" selected></option>
    <?php foreach ($listeSalaries as $salarie) { ?>
      <option value="<?php $salarie->getPerNum()?>"><?php echo $personneManager->getPersonne($salarie->getPerNum())->getPerNom() ?></option><br>
    <?php } ?>
  </select>
  </br>


  <label for="cit_date">Date citation : </label>
    <input type="date" name="cit_date" id="cit_date" />
  </br>

  <label for="vot_valeur">Note Obtenue : </label>
    <input type="textarea" name="vot_valeur" id="vot_valeur" />
  </br>

  <input type="submit" value="Valider" class="btn">
</form><br>

<?php
if(empty($_POST['per_num']) && empty($_POST['cit_date']) && empty($_POST['vot_valeur'])){
  	$citManager = new CitationManager($pdo);
  	$citations = $citManager -> getAllCitations();
  ?>
  <div class="tab">

  <table id="tableCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){?>
  	<tr>
  		<td><?php echo $personneManager->getPersonne($citation->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($citation->getPerNum())->getPerNom();?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyNote();?></td>
  	</tr>
  	<?php }?>

  </table>
</div>
  <br />
<?php } else {
  $citManager = new CitationManager($pdo);
  $citations = $citManager -> getFiltredCitation($_POST['per_num'],$_POST['cit_date'],$_POST['vot_valeur']);
  ?>
  <table id="tableCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){?>
  	<tr>
  		<td><?php echo $personneManager->getPersonne($citation->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($citation->getPerNum())->getPerNom();?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyenneNote();?></td>
  	</tr>
  	<?php }?>

  </table>
  <br /><?php
}?>


<?php
}else{
  ?>
  <p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Vous devez être connecté pour accéder à cette page !</p>
  <p>Redirection automatique dans 3 secondes...</p>
  <?php
  header("Refresh: 3;URL=index.php");
}
?>
