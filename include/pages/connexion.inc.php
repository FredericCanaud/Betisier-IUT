<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
    </head>
    <body>
        <?php
          $numero1 = rand(1,9);
          $numero2 = rand(1,9);
        ?>
        <h1> Pour vous connecter </h1>
        <?php
        if(!isset($_SESSION["login"])){
          if (empty($_POST["per_login"]) && empty($_POST["per_pwd"])){
            $_SESSION["bonResultat"] = $numero1 + $numero2;
          ?>
          <form action="index.php?page=13" id="insert" method="post">

          	<label>Nom d'utilisateur</label>
            <input type="text" name="per_login"  id="per_login" size="10"> <br>
            <label>Mot de passe</label>
            <input type="password" name="per_pwd" id="per_pwd" size="10"> <br>
            <img src="image/nb/<?php echo $numero1 ?>.jpg" alt="<?php echo $numero1 ?>" title="<?php echo $numero1 ?>"/>
            <label> + </label>
            <img src="image/nb/<?php echo $numero2 ?>.jpg" alt="<?php echo $numero2 ?>" title="<?php echo $numero2 ?>"/>
            <label> = </label>
            <input type="text" name="result" id="result" size="10"> <br>
          	<input type="submit" value="Valider"/>
          </form>
          <br />
          <?php
          }
          if(!empty($_POST["per_login"]) && !empty($_POST["per_pwd"]) && !empty($_POST["result"])){

              if($_POST["result"] == $_SESSION["bonResultat"]){

                  $personneManager = new PersonneManager($pdo);

                  $salt="48@!alsd";
                  $pwd_crypte=sha1(sha1($_POST["per_pwd"]).$salt);

                  $login = $personneManager->getLogin($_POST["per_login"],$pwd_crypte);

                  if ($login){
                      ?>
                      <p> Vous avez bien été connecté ! </p>
                      <img src="image/valid.png" />
                      <p> Redirection automatique dans 2 secondes </p>

                      <?php
                        header("refresh:2;url=index.php");
                        $_SESSION["login"] = $_POST["per_login"];
                        $_SESSION['estConnecte'] = true;
                        $_SESSION['admin'] = $personneManager->isAdmin($login->per_login);
                      ?>
                  <?php }
                  else{
                    ?>
                    <p> Login ou mot de passe incorrect ! </p>
                    <img src="image/erreur.png" />
                    <p> Redirection automatique dans 2 secondes </p>

                    <?php
                      header("refresh:2;url=index.php?page=13");
                  }
              }
              else{
                ?>
                <p> Vous êtes nul en maths ! </p>
                <img src="image/erreur.png" />
                <p> Redirection automatique dans 2 secondes </p>

                <?php
                  header("refresh:2;url=index.php?page=13");
              }
          }
        }
        else{
            header("refresh:2;url=index.php");
            session_destroy();
          ?>
          <p> Vous avez bien été déconnecté ! </p>
          <img src="image/valid.png"/>
          <p> Redirection automatique dans 2 secondes </p>

          <?php
        }

        ?>
			</body>
</html>
