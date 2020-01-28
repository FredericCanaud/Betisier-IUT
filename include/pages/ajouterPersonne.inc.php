<?php
  $personneManager = new PersonneManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $etudiantManager = new EtudiantManager($pdo);
    if ((!empty($_POST["sal_telprof"]) && !empty($_POST["fonction"]))) {

      $salarieManager->ajouterSalarie($_SESSION["loginPersonne"], $_POST["sal_telprof"], $_POST["fonction"]); ?>
            <p> Le salarié a été ajouté ! </p>
            <img src="image/valid.png" />
            <p> Redirection automatique dans 2 secondes </p>
            <?php header("refresh:2;url=index.php");

    } else if ((!empty($_POST["annee"])) && !empty($_POST["departement"])) {

    $etudiantManager->ajouterEtudiant($_SESSION["loginPersonne"], $_POST["departement"], $_POST["annee"]);
    unset($_SESSION["loginPersonne"]); ?>
            <p> L'étudiant a été ajouté ! </p>
            <img src="image/valid.png" />
            <p> Redirection automatique dans 2 secondes </p>
            <?php header("refresh:2;url=index.php");

    } else if (empty($_POST["per_nom"])) {
    ?>
          <h1>Ajouter une personne</h1>
					<form action="index.php?page=1" id="insert" method="post">

						<label>Nom :</label>
						<input type="text" name="per_nom"  id="per_nom" size="10" requiered maxlength="30"> <br>
						<label>Prénom : </label>
						<input type="text" name="per_prenom" id="per_prenom" size="10" requiered maxlength="30"> <br>
						<label>Téléphone : </label>
						<input type="tel" name="per_tel" id="per_tel" size="10" requiered maxlength="14"> <br>
						<label>Mail : </label>
						<input type="email" name="per_mail" id="per_mail" size="10" requiered maxlength="30"> <br>
						<label>Login : </label>
						<input type="text" name="per_login" id="per_login" size="10" requiered maxlength="20"> <br>
						<label>Mot de passe : </label>
						<input type="password" name="per_pwd" id="per_pwd" size="10" requiered maxlength="100"> <br>
						<label>Catégorie : </label>
						<input type="radio" name="categorie" value="etudiant" requiered>
            <label>Etudiant </label>
						<input type="radio" name="categorie" value="salarie">
            <label>Personnel </label> <br>
						<input type="submit" value="Valider"/>

					</form>
          <?php
    } else if ($_POST["categorie"] == "etudiant") {

        $salt = "48@!alsd";
        $pwd_crypte = sha1(sha1($_POST["per_pwd"]) . $salt);
        $personneManager->ajouterPersonne($_POST["per_nom"], $_POST["per_prenom"], $_POST["per_tel"], $_POST["per_mail"], $_POST["per_login"], $pwd_crypte);
        $_SESSION["loginPersonne"] = $_POST["per_login"];
        $departementManager = new DepartementManager($pdo);
        $departements = $departementManager->getAllDepartements();
        $divisionManager = new DivisionManager($pdo);
        $divisions = $divisionManager->getAllDivisions(); ?>


          <h1>Ajouter un étudiant</h1>
          <form action="index.php?page=1" id="insert" method="post">
            <label for "annee-select">Année :</label>
            <select name="annee" id="annee-select">
              <?php foreach ($divisions as $division) { ?>
                  <option value="<?php echo $division->getDivNum() ?>"><?php echo $division->getDivNom() ?></option>
              <?php
              } ?>
            </select> <br><br>
            <label for "departement-select">Département :</label>
            <select name="departement" id="departement-select">
            <?php foreach ($departements as $departement) { ?>
                <option value="<?php echo $departement->getDepNum() ?>"><?php echo $departement->getDepNom() ?></option>
            <?php
            } ?>
            </select> <br><br>
            <input type="submit" value="Valider"/>
          <?php
        } else if ($_POST["categorie"] == "salarie") {
        $salt = "48@!alsd";
        $pwd_crypte = sha1(sha1($_POST["per_pwd"]) . $salt);
        $personneManager->ajouterPersonne($_POST["per_nom"], $_POST["per_prenom"], $_POST["per_tel"], $_POST["per_mail"], $_POST["per_login"], $pwd_crypte);
        $_SESSION["loginPersonne"] = $_POST["per_login"];
        $fonctionManager = new FonctionManager($pdo);
        $listeFonctions = $fonctionManager->getAllFonctions();?>
          <h1>Ajouter un salarié</h1>
          <form action="index.php?page=1" id="insert" method="post">
            <label>Téléphone professionnel : </label>
            <input type="text" name="sal_telprof" id="sal_telprof" size="10" requiered> <br>
            <label for "fonction-select">Fonction :</label>
            <select name="fon_num" id="fon_num">
              <?php foreach ($listeFonctions as $fonction) { ?>
                <option value="<?php echo $fonction->getFonNum(); ?>"><?php echo $fonction->getFonLib(); ?></option>
              <?php }?>
            </select>
            <input type="submit" value="Valider"/>
          <?php
} ?>
