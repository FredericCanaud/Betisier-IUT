<div id="menu">
	<div id="menuInt">
		<?php if(!isset($_SESSION["estConnecte"])){ ?>
			<p><a href="index.php?page=0"><img class = "icone" src="image/accueil.gif"  alt="Accueil"/>Accueil</a></p>
			<p><img class = "icone" src="image/personne.png" alt="Personne"/>Personne</p>
			<ul>
				<li><a href="index.php?page=2">Lister</a></li>
			</ul>
			<p><img class="icone" src="image/citation.gif"  alt="Citation"/>Citations</p>
			<ul>
				<li><a href="index.php?page=6">Lister</a></li>
			</ul>
			<p><img class = "icone" src="image/ville.png" alt="Ville"/>Ville</p>
			<ul>
				<li><a href="index.php?page=8">Lister</a></li>
			</ul>
		<?php } else if (!$_SESSION["admin"]){ ?>
			<p><a href="index.php?page=0"><img class = "icone" src="image/accueil.gif"  alt="Accueil"/>Accueil</a></p>
			<p><img class = "icone" src="image/personne.png" alt="Personne"/>Personne</p>
			<ul>
				<li><a href="index.php?page=2">Lister</a></li>
				<li><a href="index.php?page=1">Ajouter</a></li>
			</ul>
			<p><img class="icone" src="image/citation.gif"  alt="Citation"/>Citations</p>
			<ul>
				<li><a href="index.php?page=5">Ajouter</a></li>
				<li><a href="index.php?page=6">Lister</a></li>
				<li><a href="index.php?page=10">Rechercher</a></li>
			</ul>
			<p><img class = "icone" src="image/ville.png" alt="Ville"/>Ville</p>
			<ul>
				<li><a href="index.php?page=8">Lister</a></li>
				<li><a href="index.php?page=7">Ajouter</a></li>
				<li><a href="index.php?page=15">Modifier</a></li>
			</ul>
		<?php } else if ($_SESSION["admin"]){ ?>
			<p><a href="index.php?page=0"><img class = "icone" src="image/accueil.gif"  alt="Accueil"/>Accueil</a></p>
			<p><img class = "icone" src="image/personne.png" alt="Personne"/>Personne</p>
			<ul>
				<li><a href="index.php?page=2">Lister</a></li>
				<li><a href="index.php?page=1">Ajouter</a></li>
				<li><a href="index.php?page=3">Modifier</a></li>
				<li><a href="index.php?page=4">Supprimer</a></li>
			</ul>
			<p><img class="icone" src="image/citation.gif"  alt="Citation"/>Citations</p>
			<ul>
				<li><a href="index.php?page=6">Lister</a></li>
				<li><a href="index.php?page=10">Rechercher</a></li>
				<li><a href="index.php?page=11">Valider</a></li>
				<li><a href="index.php?page=12">Supprimer</a></li>
			</ul>
			<p><img class = "icone" src="image/ville.png" alt="Ville"/>Ville</p>
			<ul>
				<li><a href="index.php?page=8">Lister</a></li>
				<li><a href="index.php?page=7">Ajouter</a></li>
				<li><a href="index.php?page=15">Modifier</a></li>
				<li><a href="index.php?page=14">Supprimer</a></li>
		<?php } ?>

	</div>
</div>
