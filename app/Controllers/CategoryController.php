<?php

namespace App\Controllers;

use App\Models\Category;



// Si j'ai besoin du Model Category

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function listAction()
    {

        // Avant d'afficher la page, on veut vérifier que l'utilisateur peut la voir. Donc on appelle la méthode dédiée à cette vérification en lui donnant la liste des roles autorisés
        // $this->checkAuthorization(['catalog-manager', 'admin']);

        // On veut récupérer la liste de toutes les catégories
        // On demande donc à notre model Category d'utiliser la méthode findAll

        // La méthode findAll est maintenant une méthode statique, elle n'a pas besoin qu'on instancie la classe pour l'utiliser.
        // Pour utiliser une  méthode  statique, on utilise le nom de la classe suivi du nom de la méthode, séparés par "::" (opérateur de résolution de portée)
        $categories = Category::findAll();


        // Pour le lien de suppression on a besoin de le protéger contre les attaques CSRF
        $token = $this->generateCSRFToken();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/list', [
            'categories' => $categories,
            'token' => $token,
        ]);
    }

     /**
     * Méthode d'afficher le formulaire de création d'une catégorie
     *
     * @return void
     */
    public function addAction()
    {
        // On génère un token pour l'envoyer au formulaire
        $token = $this->generateCSRFToken();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/add', [
            'token' => $token
        ]);
    }

    /**
     * Méthode appelée par le formulaire de création d'une catégorie
     */
    public function createAction()
    {

        // On récupère les infos de notre formulaire à l'aide de filter_input. Cette fonction permet d'aller vérifier qu'une entrée de $_POST existe et nous renvoyer son contenu. Si l'entrée n'existe pas, elle renvoie null. L'avantage c'est que $name sera toujours existante
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

    
        // Comme on utilise l'approche Active Record, on doit créer une catégorie vide et la remplir avec les infos provenant du formulaire.

        $newCategory = new Category();

        
        // On utilise les données provenant du formulaire pour remplir la catégorie
        $newCategory->setName($name);
        $newCategory->setSubtitle($subtitle);
        $newCategory->setPicture($picture);
        

        // Maintenant que la catégorie est remplie avec les bonnes infos, on sauvegarde celle-ci dans la BDD en utilisant la méthode save() qui s'occupe de vérifier si la catégorie existe et la créer avec insert()
        $newCategory->save();

        // Une fois la catégorie insérée en BDD, on redirige vers la page liste des catégories
        $this->redirect('category-list');


    }

    /**
     * Affiche la page d'édition d'une catégorie
     *
     * @param int $id
     * @return void
     */
    public function editAction($id)
    {
  
        //On récupère la catégorie à modifier 
        $category = Category::find($id);
        
        // On envoie la catégorie à la vue
        $this->show('category/edit', [
            'category' => $category
        ]);
    }


    /**
     * Méthode qui permet de traiter les infos envoyées par le formulaire d'édition
     *
     * @param int $id
     * @return void
     */
    public function updateAction($id) {

        // On récupère les infos  de la catégorie depuis $_POST
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

        // On vérifie les infos reçues
        if($name === "" || $name === null) {
            echo "Le nom de la catégorie est obligatoire";
            exit;
        }

        // On récupère depuis la BDD la catégorie à modifier
        $categoryToEdit = Category::find($id);
        
        // On modifie la catégorie à éditer
        $categoryToEdit->setName($name);
        $categoryToEdit->setSubtitle($subtitle);
        $categoryToEdit->setPicture($picture);
   
        // Maintenant que notre objet Category est mis à jour, on appelle la méthode save() pour sauvegarder les modifications dans la BDD. La méthode se charge de vérifie si on travaille sur une catégorie existe et va appeler la méthode update() automatiquement
        $categoryToEdit->save();

        // Une fois la sauvegarde faite, on redirige vers la liste des catégories
        $this->redirect('category-list');

    }

    /**
     * Méthode de suppression de catégorie
     *
     * @param int $id
     * @return void
     */
    public function deleteAction($id)
    {
        // On récupère la catégorie à supprimer depuis la BDD
        $categoryToDelete = Category::find($id);

        // On appelle la méthode qui permet de supprimer une catégorie de la BDD.
        // Si la suppression a fonctionné, on redirige vers la liste
        if($categoryToDelete->delete()) {
    
            $this->redirect('category-list');
        }
    }

    public function manageHomeAction()
    {
        // On a besoin de la liste de toutes les catégories pour peupler les champs select de la page.
        $categories = Category::findAll();


        // Pour se protéger des attaques CSRF, on doit générer une clé aléatoire qu'on va envoyer au formulaire.
        $token = $this->generateCSRFToken();

        $this->show('category/manage-home',
        [
            'categories' => $categories,
            'token' => $token,
        ]);
    }

    public function saveHomeAction()
    {
        // $_POST contient un tableau "emplacement" qui contient la liste des 5 catégories à afficher en home. Ce tableau est indexé par l'ordre de ces catégories (la 1ère doit avoir un home_order à 1, etc)
        // ! Par défaut, filter_input ne récupère pas les tableaux. Il faut le forcer à récupérer les tableaux avec un 4ème argument appelé FILTER_REQUIRE_ARRAY. Si on veut ajouter un 4ème argument, il faut impérativement un 3ème argument (filtre). On utilise donc le filtre par défaut FILTER_DEFAULT en 3ème argument pour pouvoir en utiliser un 4ème.
        $emplacements = filter_input(INPUT_POST, 'emplacement', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);


        // Array_unique permet de retirer les doublons d'un tableau (au cas où on aurait choisi 2 fois une catégorie) et donc on bloque la sauvegarde
        if(count(array_unique($emplacements)) != 5) {
            $this->addError('Le nombre de catégories n\'est pas le bon ou certaines catégories sont en doublon !');
        }

        // On peut aussi vérifier qu'on ne reçoit pas de catégories vides
        foreach($emplacements as $emplacement) {
            if(empty($emplacement)) {
                $this->addError('Vous ne pouvez pas avoir de catégories vides !');
            }
        }




        // Si on a des erreurs on arrete là
        if($this->hasErrors()) {
            $this->redirect('category-managehome');
        }



        // On remet à zéro toutes les catégories
        Category::resetHomeCategories();

        // On parcourt chaque emplacement reçu et on place dans des variables séparées la position de la catégorie ($homeOrder) et l'id de la catégorie ($categoryId)
        foreach($emplacements as $homeOrder => $categoryId) {


            // On va chercher dans la BDD la catégorie à mettre à jour
            $currentCategory = Category::find($categoryId);


            // Une fois la catégorie récupérée, on modifie son home_order
            $currentCategory->setHomeOrder($homeOrder);

            // On sauvegarde la catégorie
            $currentCategory->save();


        }

        $_SESSION['successMessages'][] = "Catégories en page d'accueil modifiées !";

        $this->redirect('category-managehome');
    }
    
}                                           
