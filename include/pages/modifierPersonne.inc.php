<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){
	$personneManager = new PersonneManager($pdo);
  $etudiantManager = new EtudiantManager($pdo);
  $divisionManager = new DivisionManager($pdo);
  $departementManager = new DepartementManager($pdo);
  $villeManager = new VilleManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $fonctionManager = new FonctionManager($pdo);

  if(empty($_GET['idPersonne']) && !isset($_SESSION['estValide'])){

		$personnes = $personneManager->getAllPersonnes();

  ?>

	<h1>Modifier une personne enregistrée</h1>
  <p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

	<div class="tab">
	<table>
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Modifier</th>
		</tr>

		<?php
			foreach ($personnes as $personne){
				$numPersonne = $personne->getPerNum();?>
		<tr>
			<td><?php echo $personne -> getPerNom();?></td>
			<td><?php echo $personne -> getPerPrenom();?></td>
			<td><a href="index.php?page=3&idPersonne=<?php echo $numPersonne?>"><img class='icone' src='image/modifier.png' alt='Modifier personne'></a></td>
		</tr>

		<?php }	?>

	</table>
 </div>
<?php

//Lorsque l'utilisateur clique sur modifier
}else{

  if(!isset($_SESSION['personne'])){
    $_SESSION['estValide'] = true;
    $_SESSION['personne'] = $personneManager->getPersonne($_GET['idPersonne']);
    $_SESSION['numConnecte'] = $personneManager->getNumLogin($_SESSION['login']); ?>

    <h1>Modifier une Personne</h1>

    <form action="index.php?page=3" id="modifPersonne" method="post">

      <label for="per_nom">Nom : </label>
      <input type="text" name="per_nom" id="per_nom" value="<?php echo $_SESSION['personne']->getPerNom()?>" required/><br>
    	<label for="per_prenom">Prénom : </label>
      <input type="text" name="per_prenom" id="per_prenom" value="<?php echo $_SESSION['personne']->getPerPrenom()?>" required/><br>
    	<label for="per_tel">Téléphone : </label>
      <input type="tel" name="per_tel" id="per_tel" value="<?php echo $_SESSION['personne']->getPerTel()?>" required/><br>
    	<label for="per_mail">Mail : </label>
      <input type="email" name="per_mail" id="per_mail" value="<?php echo $_SESSION['personne']->getPerMail()?>" required/><br>
    	<label for="per_login">Login : </label>
      <input type="text" name="per_login" id="per_login" value="<?php echo $_SESSION['personne']->getPerLogin()?>" required/><br>
      <label for="per_login">Mot de passe : </label>
      <input type="password" name="per_pwd" id="per_pwd" value="<?php echo $_SESSION['personne']->getPerPwd()?>" required/><br>
      <label>Catégorie : </label>
      <input type="radio" name="categorie" value="etudiant" requiered>
      <label>Etudiant </label>
      <input type="radio" name="categorie" value="salarie">
      <label>Personnel </label> <br>
      <input type="hidden" name="per_num" id="per_num" value="<?php echo $_GET['idPersonne']?>"/>
      <input type="submit" value="Valider" class="btn">

    </form>

    <?php
  }elseif(!empty($_POST['per_nom'])){
    $_SESSION['personne'] = new Personne($_POST);
    $numPersonne = $_SESSION['personne']->getPerNum();
    if($_POST["categorie"] == "etudiant"){

      $_SESSION['etudiant'] = $etudiantManager->getEtudiant($numPersonne);
      $_SESSION['etudiant']->setPersonne($_SESSION['personne']);
      $listeDivisions = $divisionManager->getAllDivisions();
      $listeDepartements = $departementManager->getAllDepartements();
			?>
      <h1>Modifier un étudiant</h1>

      <form action="index.php?page=3" id="modifEtudiant" method="post">
        <input type="hidden" name="per_num" id="per_num" value="<?php echo $_POST['per_num']?>"/>

        <label for="div_num">Année : </label>
        <select name="div_num" id="div_num">
          <?php foreach ($listeDivisions as $division) {
            if($division->getDivNum() == $_SESSION['etudiant']->getDivNum()){
              echo "<option value=".$division->getDivNum()." selected>".$division->getDivNom()."</option>\n";
            }else{
              echo "<option value=".$division->getDivNum().">".$division->getDivNom()."</option>\n";
            }

          }?>
        </select>
        </br>
        <label for="dep_num">Département : </label>
        <select name="dep_num" id="dep_num">
          <?php foreach ($listeDepartements as $departement) {
            $ville = $villeManager->getVille($departement->getDepNum());
            if($departement->getDepNum() == $_SESSION['etudiant']->getDepNum()){
              ?>
              <option value="<?php echo $departement->getDepNum()?>" selected> <?php echo $departement->getDepNom()?></option>
              <?php
            }else{
              ?>
              <option value="<?php echo $departement->getDepNum()?>"><?php echo $departement->getDepNom() ?></option>
              <?php
            }
          }?>
        </select>
      </br>

      <input type="submit" value="Valider" class="btn">
      </form>

    <?php }else{

      $_SESSION['salarie'] = $salarieManager->getSalarie($numPersonne);
      $_SESSION['salarie']->setPersonne($_SESSION['personne']);

      $listeFonctions = $fonctionManager->getAllFonctions();
      ?>
      <h1>Modifier un salarié</h1>

      <form action="index.php?page=3" id="modifSalarie" method="post">
        <input type="hidden" name="per_num" id="per_num" value="<?php echo $_POST['per_num']?>"/>

        <label for="sal_telprof">Téléphone professionnel : </label>
          <input type="tel" name="sal_telprof" id="sal_telprof" value="<?php echo $_SESSION['salarie']->getSalTelProf()?>" required/>
        </br>

        <label for="fon_num">Fonction : </label>
        <select name="fon_num" id="fon_num">
          <?php foreach ($listeFonctions as $fonction) {
            if($fonction->getFonNum() == $_SESSION['salarie']->getFonNum()){
              echo "<option value=".$fonction->getFonNum()." selected>".$fonction->getFonLib()."</option>\n";
            }else{
              echo "<option value=".$fonction->getFonNum().">".$fonction->getFonLib()."</option>\n";
            }

          }?>
        </select>
      </br>

      <input type="submit" value="Valider" class="btn">
      </form>

  <?php
  }

}else{

  if(!empty($_POST['div_num'])){
    $etudiant = new Etudiant($_POST,$_SESSION['etudiant']->getPersonne());
    $retour = $etudiantManager->modifierEtudiant($etudiant);

    if($retour){
      ?>
      <p><img class='icone' src='image/valid.png' alt='ValiderModificationEtudiant'>L'étudiant <?php echo $etudiant->getPersonne()->getPerPrenom(); ?> <?php echo $etudiant->getPersonne()->getPerNom(); ?> a été modifié</p>
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
    }
    else{
      ?>
      <p><img class='icone' src='image/erreur.png' alt='ErreurModificationEtudiant'>L'étudiant <?php echo $etudiant->getPersonne()->getPerPrenom(); ?> <?php echo $etudiant->getPersonne()->getPerNom(); ?> n'a pu être modifié</p>
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
    }
    unset($_SESSION['etudiant']);
  }

  if(!empty($_POST['sal_telprof'])){

    $salarie = new Salarie($_POST, $_SESSION['personne']);
    $retour = $salarieManager->modifierSalarie($salarie);

    if($retour){
      ?>
      <p><img class='icone' src='image/valid.png' alt='ValiderModificationSalarie'>Le salarié <?php echo $salarie->getPersonne()->getPerPrenom(); ?> <?php echo $salarie->getPersonne()->getPerNom(); ?> a été modifié</p>
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
      if($_SESSION['numConnecte'] == $salarie->getPersonne()->getPerNum()){
        $_SESSION['login'] = $salarie->getPersonne()->getPerLogin();
      }
    }
    else{
      ?>
      <p><img class='icone' src='image/erreur.png' alt='Erreur modification salarie'>Erreur : Le salarié<?php echo $salarie->getPersonne()->getPerPrenom(); ?> <?php echo $salarie->getPersonne()->getPerNom(); ?> n'a pu être modifié</p>";
      <p>Redirection automatique dans 3 secondes...</p>
      <?php
    }
    unset($_SESSION['salarie']);
  }

  unset($_SESSION['estValide']);
  unset($_SESSION['personne']);
  unset($_SESSION['numConnecte']);
  header("Refresh: 3;URL=index.php");
}
}

}else{
  ?>
  <p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>";
  <p>Redirection automatique dans 3 secondes</p>";
  <?php
  header("Refresh: 3;URL=index.php");
}
?>
