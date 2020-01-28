<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Liste des villes</title>
    </head>
    <body>
        <?php
        ?>
				<h1>Liste des villes</h1>
				<?php
					$villeManager = new VilleManager($pdo);
					$villes=$villeManager->getAllVilles();
					?>
          <h2> Actuellement <?php echo count($villes); ?> ville(s) sont enregistrées </h2>
          <div class="tab">
					<table>
							<tr><th>Numéro</th><th>Nom</th></tr>
							<?php
						foreach ($villes as $ville){ ?>
							<tr><td><?php echo $ville->getVilNum();?>
							</td><td><?php echo $ville->getVilNom();?>
							</td></tr>
						<?php } ?>
					</table>
        </div>
			</body>
</html>
