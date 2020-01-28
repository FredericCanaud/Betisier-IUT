<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Liste des personnes</title>
    </head>
    <body>
        <?php
          if (empty($_GET["pernum"])){
            ?> <h1>Liste des personnes enregistrées</h1> <?php
					    $personneManager = new PersonneManager($pdo);
					    $personnes=$personneManager->getAllPersonnes();
					    ?>
              <h2> Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrées </h2>
					    <div class="tab">
					         <table>
							          <tr><th>Numéro</th><th>Nom</th><th>Prénom</th></tr>
							          <?php foreach ($personnes as $personne){ ?>
									      <tr>
                             <td><a href="index.php?page=2&pernum=<?php echo $personne->getPerNum();?>"><?php echo $personne->getPerNum();?></td>
                             <td><?php echo $personne->getPerNom();?></td>
                             <td><?php echo $personne->getPerPrenom();?></td>
									      </tr>
							          <?php } ?>
						       </table>
					    </div>
					    <p> Cliquez sur le numéro de la personne pour obtenir plus d'informations. </p>
         <?php }
         else {

           $personneManager = new PersonneManager($pdo);
           $personne =$personneManager->getPersonne($_GET["pernum"]);
           if ($personneManager->isEtudiant($_GET["pernum"])){

             $EtudiantManager = new EtudiantManager($pdo);

             $etudiant=$EtudiantManager->getEtudiant($_GET["pernum"]);

             $DepartementManager = new DepartementManager($pdo);
             $departement=$EtudiantManager->getDepartement($etudiant->getPerNum());

             $ville=$DepartementManager->getVille($etudiant->getDepNum());

               ?>
               <h2> Détail sur l'étudiant <?php echo $personne->getPerNom(); ?></h2>
               <div class="tabEtudiant">
                    <table>
                         <tr><th>Prénom</th><th>Mail</th><th>Tel</th><th>Département</th><th>Ville</th></tr>
                         <tr>
                              <td><?php echo $personne->getPerPrenom();?></td>
                              <td><?php echo $personne->getPerMail();?></td>
                              <td><?php echo $personne->getPerTel();?></td>
                              <td><?php echo $departement->getDepNom();?></td>
                              <td><?php echo $ville->getVilNom();?></td>
                         </tr>
                         <?php } ?>
                         </table>
               </div>
           <?php
           if ($personneManager->isSalarie($_GET["pernum"])){
             $personne=$personneManager->getPersonne($_GET["pernum"]);

             $SalarieManager = new SalarieManager($pdo);

             $salarie=$SalarieManager->getSalarie($_GET["pernum"]);

             $FonctionManager = new FonctionManager($pdo);
             $fonction=$SalarieManager->getFonction($salarie->getPerNum());
               ?>
               <h2> Détail sur le salarié <?php echo $personne->getPerNom(); ?></h2>
               <div class="tabSalarie">
                    <table>
                         <tr><th>Prénom</th><th>Mail</th><th>Tel</th><th>Tel pro</th><th>Fonction</th></tr>
                         <tr>
                              <td><?php echo $personne->getPerPrenom();?></td>
                              <td><?php echo $personne->getPerMail();?></td>
                              <td><?php echo $personne->getPerTel();?></td>
                              <td><?php echo $salarie->getSalTelprof();?></td>
                              <td><?php echo $fonction->getFonLib();?></td>
                         </tr>
                         <?php } ?>
                    </table>
               </div>
             <?php } ?>
			</body>
</html>
