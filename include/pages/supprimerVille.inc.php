<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){
  unset($_SESSION['ville']);
  $villeManager = new VilleManager($pdo);
  if(empty($_GET['idVille']) && !isset($_SESSION['ville'])){
  	$villes = $villeManager -> getAllVilles();
  ?>
  <h1>Supprimer une ville enregistrée</h1>
  <p>Actuellement <?php echo count($villes) ?> ville(s) sont enregistrée(s)</p>
  <div class="tab">
  <table>
  	<tr>
  		<th>Numéro</th>
  		<th>Nom</th>
      <th>Supprimer</th>
  	</tr>
  </div>

  	<?php
  		foreach ($villes as $ville){
        $vil_num = $ville->getVilNum()?>
  	<tr>
  		<td><?php echo $ville->getVilNum();?></td>
  		<td><?php echo $ville->getVilNom();?></td>
      <td><a href="index.php?page=14&idVille=<?php echo $vil_num;?>"><img class='icone' src='image/erreur.png' alt='Supprimer ville'></a></td>
  	</tr>
  	<?php } ?>

  </table>
  <br />

<?php
}else
  if (isset($_GET['idVille'])) {
    $_SESSION['ville'] = $villeManager->getVille($_GET['idVille']);
    $retour = $villeManager->supprimerVille($_SESSION['ville']);

    if($retour){
      ?>
      <p><img class='icone' src='image/valid.png' alt='SupprimerVilleValide'>La ville <?php echo $_SESSION['ville']->getVilNom() ?> a été supprimée !</p>
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
    }
    else{
      ?>
      <p><img class='icone' src='image/erreur.png' alt='SupprimerVillErreur'>Erreur : La ville <?php echo $_SESSION['ville']->getVilNom() ?> est encore associée à un ou plusieurs étudiants, suppression impossible !</p>
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
    }
    unset($_SESSION['ville']);
    header("Refresh: 3;URL=index.php?page=14");
  }

}else{
  ?>
  <p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Erreur : Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>
  <p>Redirection automatique dans 3 secondes...</p>
  <?php
  header("Refresh: 3;URL=index.php");
}
?>
