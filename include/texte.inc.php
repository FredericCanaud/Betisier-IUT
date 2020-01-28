<div id="texte">
<?php
if (!empty($_GET["page"])){
	$page=$_GET["page"];}
	else
	{$page=0;
	}
switch ($page) {

case 0:
	include_once('pages/accueil.inc.php');
	break;
case 1:
	include("pages/ajouterPersonne.inc.php");
    break;
case 2:
	include_once('pages/listerPersonnes.inc.php');
    break;
case 3:
	include("pages/modifierPersonne.inc.php");
    break;
case 4:
	include_once('pages/supprimerPersonne.inc.php');
    break;
case 5:
    include("pages/ajouterCitation.inc.php");
    break;
case 6:
	include("pages/listerCitation.inc.php");
    break;
case 7:
	include("pages/ajouterVille.inc.php");
    break;
case 8:
	include("pages/listerVilles.inc.php");
    break;
case 9:
	include("pages/noterCitation.inc.php");
    break;
case 10:
	include("pages/rechercherCitation.inc.php");
    break;
case 11:
	include("pages/validerCitation.inc.php");
		break;
case 12:
  include("pages/supprimerCitation.inc.php");
    break;
case 13:
	include("pages/connexion.inc.php");
    break;
case 14:
	include("pages/supprimerVille.inc.php");
		break;
case 15:
  include("pages/modifierVille.inc.php");
		break;
default : 	include_once('pages/accueil.inc.php');
}

?>
</div>
