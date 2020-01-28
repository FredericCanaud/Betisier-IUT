<?php
if(isset($_SESSION['estConnecte'])){

  ?>
  <h1>Modifier une ville enregistrée</h1>
  <?php
    $villeManager = new VilleManager($pdo);
  if(empty($_GET['idVille']) && !isset($_SESSION['ville'])){
  	$villes = $villeManager -> getAllVilles();
  ?>

  <p>Actuellement <?php echo count($villes) ?> ville(s) sont enregistrée(s)</p>
  <div class="tab">
  <table>
  	<tr>
  		<th>Numéro</th>
  		<th>Nom</th>
      <th>Modifier</th>
  	</tr>
  </div>

  	<?php
  		foreach ($villes as $ville){
        $numVille = $ville->getVilNum()?>
  	<tr>
  		<td><?php echo $ville->getVilNum();?></td>
  		<td><?php echo $ville->getVilNom();?></td>
      <td><a href="index.php?page=15&idVille=<?php echo $numVille?>"><img class='icone' src='image/modifier.png' alt='Modifier ville'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

<?php
}else{

  if(empty($_POST['vil_nom'])){
      $_SESSION['ville'] = $villeManager->getVille($_GET['idVille']); ?>

  <form action="index.php?page=15" id="modifVille" method="post">

    <label for="vil_nom">Nom : </label>
      <input type="text" name="vil_nom" id="vil_nom" value="<?php echo $_SESSION['ville']->getVilNom()?>" required/>
    </br>
  	<input type="submit" value="Valider" class="btn">

  </form>

<?php }else{
  $_SESSION['ville']->setVilNom($_POST['vil_nom']);
	$retour = $villeManager->modifierVille($_SESSION['ville']);

  if($retour){
    ?>
    <p><img class='icone' src='image/valid.png' alt='ModificationValideVille'>La ville <?php echo $_SESSION['ville']->getVilNom() ?> a été modifiée !</p>
    <p>Redirection automatique dans 3 secondes..</p>
    <?php
  }
  else{
    ?>
    <p><img class='icone' src='image/erreur.png' alt='ModificationErreurVille'>La ville <?php echo $_SESSION['ville']->getVilNom() ?> existe déjà !</p>
    <p>Redirection automatique dans 3 secondes..</p>
    <?php
  }
  unset($_SESSION['ville']);
  header("Refresh: 3;URL=index.php");
}
}

}else{
  ?>
  <p><img class = 'icone' src='image/erreur.png' alt='ErreurConnexion'>Erreur : Vous devez être connecté pour accéder à cette page !</p>";
  <p>Redirection automatique dans 3 secondes..</p>
  <?php
  header("Refresh: 3;URL=index.php");
}
?>
