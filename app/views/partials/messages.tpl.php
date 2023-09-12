<?php 

// dump($_SESSION);
// Pour afficher les erreurs, on commence par vérifier si la "boite à erreurs" dans la session existe
if(isset($_SESSION["errorMessages"])){

    // on récupère la "boite à erreurs" dans une variable
    $errorsList = $_SESSION['errorMessages'];

    // On parcourt la liste des messages d'erreur avec une boucle
    foreach($errorsList as $error) : ?>
        <div class="alert alert-danger" role="alert">
         <?= $error ?>
        </div>
   <?php endforeach;

   // Une fois qu'on affiché toutes les erreurs de la boite : on la supprime
   unset($_SESSION['errorMessages']);

}


// Pour afficher les messages de succès, on commence par vérifier si la "boite à succès" dans la session existe
if(isset($_SESSION["successMessages"])){

    // on récupère la "boite à succès" dans une variable
    $successList = $_SESSION['successMessages'];

    // On parcourt la liste des messages de succès avec une boucle
    foreach($successList as $success) : ?>
        <div class="alert alert-success" role="alert">
         <?= $success ?>
        </div>
   <?php endforeach;

   // Une fois qu'on affiché toutes les messages de la boite : on la supprime
   unset($_SESSION['successMessages']);

}
?>