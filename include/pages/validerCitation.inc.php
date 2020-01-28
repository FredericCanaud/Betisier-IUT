<?php
$citationManager = new CitationManager($pdo);
$personneManager = new PersonneManager($pdo);
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){ ?>

  <h1>Valider une citation enregistrée</h1>

  <?php if(empty($_GET['idCitVal']) && empty($_GET['idCitSup']) && !isset($_SESSION['citation'])){
  	$citations = $citationManager -> getAllNewCitations();
  ?>

  <p>Actuellement <?php echo count($citations); ?> citation(s) sont enregistrée(s)</p>

  <table id="tableValCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){
        $numCit = $citation->getCitNum()?>
  	<tr>
      <td><?php echo $personneManager->getPersonne($citation->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($citation->getPerNum())->getPerNom();?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
      <td><a href="index.php?page=11&idCitVal=<?php echo $numCit;?>"><img class='icone' src='image/valid.png' alt='Valider Citation'></a></td>
      <td><a href="index.php?page=11&idCitSup=<?php echo $numCit;?>"><img class='icone' src='image/erreur.png' alt='Supprimer Citation'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

  <?php
  }else{
    if(!empty($_GET['idCitSup']) || !empty($_GET['idCitVal'])){
      if (!empty($_GET['idCitSup'])) {
						$_SESSION['citation'] = $citationManager->getCitation($_GET['idCitSup']);
						$enseignant = $personneManager->getPersonne($_SESSION["citation"]->getPerNum())->getPerNom();
            $citationManager->delete($_SESSION['citation']);
						?>
            <p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation de <?php echo $enseignant; ?> a été supprimée</p>
            <?php
						unset($_SESSION['citation']);
            unset($_SESSION['supprimer']);
            header("Refresh: 3;URL=index.php?page=11");

      }elseif(!empty($_GET['idCitVal'])){
						$_SESSION['citation'] = $citationManager->getCitation($_GET['idCitVal']);
						$enseignant = $personneManager->getPersonne($_SESSION["citation"]->getPerNum())->getPerNom();
            $retour = $citationManager->valider($_SESSION['citation'], $_SESSION['login']);
						?>
            <p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation de <?php echo $enseignant; ?> a été validée</p>
						<?php
						unset($_SESSION['supprimer']);
            unset($_SESSION['citation']);
            header("Refresh: 3;URL=index.php?page=11");
			}
    }
  }
}else{
		?>
    <p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'> Erreur : Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>
    <p>Redirection automatique dans 3 secondes...</p>
		<?php
    header("Refresh: 3;URL=index.php");
}
?>
