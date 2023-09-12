<?php

namespace App\Controllers;

use App\Models\Type;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Controllers\CoreController;
use App\Models\Tag;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class ProductController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des produits
     *
     * @return void
     */
    public function list()
    {

        // $this->checkAuthorization(['catalog-manager', 'admin']);

        // On a besoin de tous les produits
        $products = Product::findAll();

     
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/list', [
            'products' => $products
        ]);
    }

     /**
     * Méthode permettant d'afficher le formulaire de création d'un produit
     *
     * @return void
     */
    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/add');
    }

    /**
     * Méthode appelée par le formulaire de création d'un produit
     */
    public function create()
    {

        // On récupère les infos de notre formulaire à l'aide de filter_input. Cette fonction permet d'aller vérifier qu'une entrée de $_POST existe et nous renvoyer son contenu. Si l'entrée n'existe pas, elle renvoie null. L'avantage c'est que $name sera toujours existante
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = intval(filter_input(INPUT_POST, 'rate'));
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $categoryId = intval(filter_input(INPUT_POST, 'category'));
        $brandId = intval(filter_input(INPUT_POST, 'brand'));
        $typeId = intval(filter_input(INPUT_POST, 'type'));

    
        // Comme on utilise l'approche Active Record, on doit créer un produit vide et le remplir avec les infos provenant du formulaire.

        $newProduct = new Product();

        
        // On utilise les données provenant du formulaire pour remplir l'objet product
        $newProduct->setName($name);
        $newProduct->setDescription($description);
        $newProduct->setPicture($picture);
        $newProduct->setPrice($price);
        $newProduct->setRate($rate);
        $newProduct->setStatus($status);
        $newProduct->setCategoryId($categoryId);
        $newProduct->setBrandId($brandId);
        $newProduct->setTypeId($typeId);
       


        // Maintenant que le produit est rempli avec les bonnes infos, on sauvegarde celui-ci dans la BDD en utilisant la méthode insert();
        $newProduct->insert();

        // Une fois le produit inséré en BDD, on redirige vers la page liste des produits
        $this->redirect('product-list');


    }

       /**
     * Page affichant le formulaire d'édition de produit
     *
     * @return void
     */
    public function editAction($id)
    {
        
        // Pour faire fonctionner le formulaire, on a besoin de récupérer la liste des catégories, types et marques
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();
        $tags = Tag ::findAll();
        

        // On va chercher dans la BDD le produit à éditer
        $product = Product::find($id);

        $this->show('product/edit', [
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types,
            'product' => $product,
            'tags' => $tags
        ]);
    }

    public function updateAction($id)
    {
        // On a besoin de récupérer tous les champs du formulaire
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        // On vérifie que l'image est une vraie url
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        // On vérifie que le prix est un nombre décimal
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        // On peut vérifier que $rate est un entier entre 1 et 5
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
        $brand = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT);
        $type = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);

        // On va chercher le produit à mettre à jour
        $product = Product::find($id);


        // On remplit ses propriétés à l'aide des setters
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setCategoryId($category);
        $product->setBrandId($brand);
        $product->setTypeId($type);

        // On sauvegarde les modifications dans la BDD avec la méthode save. Celle-ci retourne true ou false selon si ça a fonctionné ou non
        $success = $product->save();

        // Si ça a fonctionné ($success contient true) on redirige.
        if($success) {
            $this->redirect('product-list');
        }

    }
}
