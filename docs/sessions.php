<?php 

// Les sessions sont des petits espaces de stocakge coté serveur. Chaque session (chaque espace de stockage) possède une clé qui lui correspond et peut l'ouvrir. Cette clé est donnée au navigateur sous forme d'une cookie PHPSESSID.

// Pour utiliser les sessions, toutes nos pages doivent exécuter la fonction session_start() le plus tot possible

session_start();


// Grace à session_start(), au chargement de la page, PHP fait une vérification : il vérifie qu'on possède un cookie appelée SESSID.
// Si oui, il nous donne accès à notre "coffre fort" et aux infos qu'il contient
// Si non, il nous crée un nouveau "coffre-fort" et nous la clé associée sous forme d'un cookie.


// La session est représentée sous la forme d'une superglobale appelée $_SESSION. On peut lire et écrire des infos à l'intérieur avec PHP tant qu'on possède le cookie-clé PHPSESSID.  
// ! Si on perd la clé, PHP nous génère une nouvelle session et une nouvelle clé. On perd alors accès à tout ce qu'il y avait dans la session.


// On peut se servir de ce tableau pour stocker l'information comme quoi l'utilisateur est connu car il a déjà fourni une fois son email et son mot de passe.

$_SESSION['connect'] = true;

var_dump($_SESSION);