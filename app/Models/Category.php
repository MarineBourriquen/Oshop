<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        // self::class permet d'afficher le FQCN (nom complet) de la classe dans laquelle on se situe
        $category = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $categories;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table (sauf les colonnes qui ont une valeur par défaut dans la BDD : id, created_at, home_order)
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        // Pour se protéger des injections SQL notre requete doit comporter des "emplacements". Des sortes de cases dans lesquelles on mettra les vraies valeurs plus tard.
        // Par convention, un emplacement commence par ":" et porte le nom du champ.
        $sql = "INSERT INTO `category` (`name`, `subtitle`, `picture` )
        VALUES (:name, :subtitle, :picture)
        ";

        // Une fois la requete créée, on la confie à PDO pour qu'il prenne connaissance de celle-ci.
        $query = $pdo->prepare($sql);

        // Maintenant qu'il sait que la requete est une requete INSERT INTO qui contient 3 emplacements, on les remplit avec nos valeurs
        $query->bindValue(':name', $this->name);
        $query->bindValue(':subtitle', $this->subtitle);
        $query->bindValue(':picture', $this->picture);


        // On exécute la requete préparée à l'aide de la méthode execute
        $insertedRows = $query->execute();

        // Si au moins une ligne ajoutée
        if ($insertedRows) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table category
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
            UPDATE `category`
            SET
                name = :name,
                subtitle = :subtitle,
                picture = :picture,
                home_order = :home_order,
                updated_at = NOW()
            WHERE id = :id
        ";

        // On envoie la requete à PDO avec des emplacements pour qu'il la prépare.
        $query = $pdo->prepare($sql);

        // Une fois que PDO est courant du format de la requete, on lui donne les valeurs à mettre dans les emplacements
        // Le 3ème argument permet de forcer la vérification d'un type de donnée (par défaut c'est string : PDO::PARAM_STR, si on veut vérifier un entier c'est PDO::PARAM_INT)
        $query->bindValue(':name', $this->name, PDO::PARAM_STR);
        $query->bindValue(':subtitle', $this->subtitle, PDO::PARAM_STR);
        $query->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $query->bindValue(':home_order', $this->home_order, PDO::PARAM_INT);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        // Execution de la requête de mise à jour avec la méthode execute
        $updatedRows = $query->execute();
        // On retourne VRAI, si au moins une ligne ajoutée
        return ($updatedRows);
    }


    /**
     * Méthode supprimant l'objet courant de la BDD
     *
     * @return void
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On se crée une requete SQL de suppression. Comme l'ID est modifiable depuis l'url par l'utilisateur, on fait une requete préparée.
        $sql = "DELETE FROM `category`
        WHERE `id` = :id";

        // On confie à PDO la requete SQL qu'il va recevoir. Ainsi il est informé du nombre d'éléments qui vont composer cette requete. 
        $pdoStatement = $pdo->prepare($sql);

        // On remplace l'emplace :id par sa vraie valeur
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        // On execute la requete et on retourne ce que la méthode execute nous renvoie (true ou false)
        return $pdoStatement->execute();
        
    }


    /**
     * Méthode mettant à zéro les home order de tous les catégories
     *
     * @return Int
     */
    public static function resetHomeCategories()
    {
        // On fait une requete qui remet à zéro les catégories dont le home_order est différent de 0
        $sql = "UPDATE `category`
        SET `home_order` = 0
        WHERE `home_order` > 0";

        $pdo = Database::getPDO();

        // Comme la requete ne contient aucune info de l'extérieur pas besoin de la préparer. Et comme on ne veut pas récupérer un jeu de résultats, on utilise exec plutot que query
        return $pdo->exec($sql);

    }


}
