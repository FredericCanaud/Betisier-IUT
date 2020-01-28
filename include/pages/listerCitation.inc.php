<?php
  $citationManager = new CitationManager($pdo);
  $citations=$citationManager->getAllCitations();
  $personneManager = new PersonneManager($pdo);
  $voteManager = new VoteManager($pdo);
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Liste des citations</title>
    </head>
    <body>
				<h1>Liste des citations déposées</h1>
          <h2> Actuellement <?php echo count($citations); ?> citation(s) sont enregistrées </h2>
          <div class="tab">
					<table>
							<tr><th>Nom de l'enseignant</th><th>Libellé</th><th>Date</th><th>Moyenne des notes</th></tr>
							<?php

						  foreach ($citations as $citation){

              $citnum = $citation->getCitNum();
              $pernum = $personneManager->getNumLogin($_SESSION['login']); ?>
              <td><?php echo $personneManager->getPersonne($citation->getPerNum())->getPerPrenom().' '.$personneManager->getPersonne($citation->getPerNum())->getPerNom();?></td>
							</td><td><?php echo $citation->getCitLib();?>
							</td><td><?php echo $citation->getCitDate();?>
							</td><td><?php echo $citation->getMoyNote();?>
              </td>
              <?php if (!empty($_SESSION['login'])){
            	   if ($personneManager->isEtudiant($pernum) && $voteManager->getNoteCitationPersonne($citnum,$pernum)){ ?>
            		    <td><img src='image/erreur.png' alt='Déja noté'/></td>
                 <?php } else if ($personneManager->isEtudiant($pernum)) { ?>
                    <td><a href='index.php?page=9&citnum=<?php echo $citnum; ?>'><img src='image/modifier.png' alt='Pas encore noté'/></a></td>
                 <?php }
                 } ?>
							</tr>
						<?php } ?>
          </div>
					</table>
			</body>
