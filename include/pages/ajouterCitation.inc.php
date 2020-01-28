<?php
if ($_SESSION['login']) {

    $_SESSION['aDesMotsInterdits'] = false;
    $personneManager = new PersonneManager($pdo);
    $citationManager = new CitationManager($pdo);
    $motManager = new MotManager($pdo);

    if (empty($_POST["cit_libelle"])) {

        $estUneCorrection = false;

    } else {

        $estUneCorrection = !$motManager->estUnePhraseCorrecte($_POST["cit_libelle"]);

    }
    if (!empty($_POST["cit_libelle"]) && !$estUneCorrection) {

        $pernumetu = $personneManager->getNumLogin($_SESSION["login"]);
        $citationManager->ajouterCitation($_POST["per_num"], $pernumetu, $_POST["cit_date"], $_POST["cit_libelle"]); ?>
        <h4> Insertion effectuée ! </h4>

    <?php } ?>

    <h1>Ajouter une citation</h1>

    <form action="index.php?page=5" id="ajout" method="post">

      <label> Enseignant : </label>

      <select name = "per_num">
      <?php foreach ($personneManager->listerEnseignant() as $enseignant) { ?>
         <option value ='<?php echo $enseignant->getPerNum(); ?>'><?php echo $enseignant->getPerNom(); ?></option>'
      <?php} ?>
      </select><br>

      <label> Date : </label>
      <input type="date" name="cit_date" id="date"
      <?php
        if ($estUneCorrection) {
      ?>
        value='<?php $_POST['cit_date']; ?>'
      <?php } ?>><br>

      <label> Citation : </label>

      <textarea rows="4" cols="50" name ="cit_libelle">

      <?php if ($estUneCorrection) {
        echo ($motManager->getPhraseCorrecte($_POST['cit_libelle']));
      } ?>
  	  </textarea>

  	  <?php
      if ($estUneCorrection) {
          foreach ($motManager->getAllMotsInterdits($_POST["cit_libelle"]) as $mot) { ?>
              <imgsrc='image/erreur.png'>
              <p>Le mot <?php echo $mot ?> est interdit !</p>
  		    <?php}
      } ?>

    <input type="submit" value="Valider"/>
  </form>

<?php
} else { ?>
  <p>Vous devez être connecté en tant qu'étudiant pour accéder à cette page !</p>
  <img src='image/erreur.png'>
  <p> Redirection automatique dans 3 secondes</p>
  <?php header("Refresh: 2;URL=index.php");
}
?>
