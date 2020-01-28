<h1>Ajouter une ville</h1>
<?php
    $villeManager = new VilleManager($pdo);
    if (empty($_POST["vil_nom"])) {
?>
    <form action="index.php?page=7" id="insert" method="post">

          	<label>Nom :</label>
            <input type="text" name="vil_nom"  id="vil_nom" size="10"> <br> <br>
          	<input type="submit" value="Valider"/>

    </form>
<?php } else {
    $villeManager->ajouterVille($_POST["vil_nom"]);
?>
            <p> La ville "<?php echo $_POST["vil_nom"] ?>" a bien été ajoutée !</p>
            <img src="image/valid.png" />
            <p> Redirection automatique dans 3 secondes...</p>
<?php
    header("refresh:2;url=index.php");
} ?>
