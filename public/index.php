<?php



// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

// Le plus tot possible on active les sessions
// ! MAIS toujours après l'autoloading (sinon bug) 
session_start();
/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => 'MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);

$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'listAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-list'
);


$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'addAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-add'
);

$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'createAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-create'
);

$router->map(
    'GET',
    '/category/update/[i:id]',
    [
        'method' => 'editAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-edit'
);

$router->map(
    'POST',
    '/category/update/[i:id]',
    [
        'method' => 'updateAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-update'
);

// Route de suppression d'une catégorie
$router->map(
    'GET',
    '/category/delete/[i:id]',
    [
        'method' => 'deleteAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-delete'
);


$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => 'ProductController' // On indique le FQCN de la classe
    ],
    'product-list'
);


$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => 'ProductController' // On indique le FQCN de la classe
    ],
    'product-add'
);

$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'create',
        'controller' => 'ProductController' // On indique le FQCN de la classe
    ],
    'product-create'
);


$router->map(
    'GET',
    '/product/update/[i:id]',
    [
        'method' => 'editAction',
        'controller' => 'ProductController' // On indique le FQCN de la classe
    ],
    'product-edit'
);

$router->map(
    'POST',
    '/product/update/[i:id]',
    [
        'method' => 'updateAction',
        'controller' => 'ProductController' // On indique le FQCN de la classe
    ],
    'product-update'
);

// Route qui affiche le formulaire de connexion
$router->map(
    'GET',
    '/login',
    [
        'method' => 'loginFormAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-loginform'
);

// Route qui traite les données du formulaire de connexion
$router->map(
    'POST',
    '/login',
    [
        'method' => 'connectAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-connect'
);
// Route qui déconnecte l'utilisateur
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logoutAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-logout'
);
// Route qui liste les utilisateurs
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'listAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-list'
);
// Route qui affiche le formulaire d'ajout d'utilisateur
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'addAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-add'
);

// Route qui traite les données d'ajout d'utilisateur
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'createAction',
        'controller' => 'UserController' // On indique le FQCN de la classe
    ],
    'user-create'
);


// Route qui affiche le formulaire de choix des catégories sur l'accueil
$router->map(
    'GET',
    '/category/manage-home',
    [
        'method' => 'manageHomeAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-managehome'
);

// Route qui traite les données du formulaire de choix des catégories sur l'accueil
$router->map(
    'POST',
    '/category/manage-home',
    [
        'method' => 'saveHomeAction',
        'controller' => 'CategoryController' // On indique le FQCN de la classe
    ],
    'category-savehome'
);




/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();


// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, 'ErrorController::err404');

// La méthode setControllersNamespace permet de définir un namespace commun à tous nos controllers. Ainsi on évite la répétition de ce namespace et donc les erreurs
$dispatcher->setControllersNamespace('App\Controllers');

// La méthode setControllersArguments permet d'envoyer au constructeur du controller des informations. Elles seront récupérées en paramètre du constructeur
$dispatcher->setControllersArguments($match['name'], $router);

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
