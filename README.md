# Betisier De l'IUT du Limousin - Module M3104

Réalisation d'un site web codé en PHP durant les séances de TP du module M3104 : le bêtisier de l'IUT !

## 1- Informations
- Les mots de passes des personnes sont codés avec la fonction sha1.
- La table mot de passe possède un index FULLTEXT. Les mots interdits doivent être constitué au minimum de 3 lettres, il s'agit d'un réglage MySQL. [Détails ici](http://stackoverflow.com/a/17797003)

## 2- Fonctionnalités demandées
- Conception Objet (Classe, Manager, PDO, ..)
- Programmation modulaire exigée
- Gestion des droits d'accès aux différentes fonctionnalités (connexion et droits d'accès)
- Listage, modification et suppression des villes
- Listage, ajout, modification et suppression de personne
- Liste, ajout, suppression, et validation de citation
- Lors de l'ajout d'une citation, certains mots sont interdits (index fulltext)
- Une citation ne peut-être affichée publiquement et ouverte au vote que si elle a été approuvée par un administrateur
- Possiblité pour les élèves de voter pour des citations
- Le site doit être valide W3C (HTML et CSS)

## 3- Fonctionnalités supplémentaires

- Bon formatage du numéro de téléphone et de l'adresse mail
- Il est possible de saisir les dates à l'aide d'un calendrier
