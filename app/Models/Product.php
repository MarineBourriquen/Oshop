<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;


    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($productId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table product
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table 
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
        $sql = "INSERT INTO `product` 
            (
            `name`, 
            `description`, 
            `picture`,
            `price`,
            `rate`,
            `status`,
            `category_id`,
            `brand_id`,
            `type_id`
            )
        VALUES (
            :name, 
            :description, 
            :picture,
            :price,
            :rate,
            :status,
            :category_id,
            :brand_id,
            :type_id
            )
        ";

        // Une fois la requete créée, on la confie à PDO pour qu'il prenne connaissance de celle-ci.
        $query = $pdo->prepare($sql);

        // Maintenant qu'il sait que la requete est une requete INSERT INTO qui contient 3 emplacements, on les remplit avec nos valeurs
        $query->bindValue(':name', $this->name);
        $query->bindValue(':description', $this->description);
        $query->bindValue(':picture', $this->picture);
        $query->bindValue(':price', $this->price);
        $query->bindValue(':rate', $this->rate);
        $query->bindValue(':status', $this->status);
        $query->bindValue(':category_id', $this->category_id);
        $query->bindValue(':brand_id', $this->brand_id);
        $query->bindValue(':type_id', $this->type_id);



        // On exécute la requete préparée à l'aide de la méthode execute
        $insertedRows = $query->execute();

        // Si au moins une ligne ajoutée
        if ($insertedRows > 0) {
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
     * Méthode sauvegardant les modifications d'un produit dans la BDD
     *
     * @return void
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
            UPDATE `product`
            SET
                name = :name,
                description = :description,
                picture = :picture,
                price = :price,
                rate = :rate,
                status = :status,
                category_id = :category_id,
                brand_id = :brand_id,
                type_id = :type_id,
                updated_at = NOW()
            WHERE id = :id
        ";

        // On confie à PDO la requete SQL qu'il va recevoir. Ainsi il est informé du nombre d'éléments qui vont composer cette requete. 
        $pdoStatement = $pdo->prepare($sql);

        // Maintenant que la requete est préparée et que PDO est au courant de ses limites et emplacements, on remplace ces derniers par leurs vraies valeurs grace à bindValue().
        // On peut forcer le type de la donnée grace au troisème argument (par défaut il force la donnée en string)
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':name', $this->name);
        $pdoStatement->bindValue(':description', $this->description);
        $pdoStatement->bindValue(':picture', $this->picture);
        $pdoStatement->bindValue(':price', $this->price);
        $pdoStatement->bindValue(':rate', $this->rate);
        $pdoStatement->bindValue(':status', $this->status);
        $pdoStatement->bindValue(':category_id', $this->category_id);
        $pdoStatement->bindValue(':brand_id', $this->brand_id);
        $pdoStatement->bindValue(':type_id', $this->type_id);

        // On execute la requete avec la méthode execute
        $success = $pdoStatement->execute();

        // Si ça a marché, $success contient true, sinon false
        return $success;
    }


    public function delete()
    {
        // TODO : coder cette méthode
    }


    /**
     * Retourne tous les tags du produit courant
     *
     * @return Tag[]
     */
    public function getTags()
    {
        // On retourne tous les tags du produit courant en utilisant la méthode findByProduct du model Tag
        $tags = Tag::findByProduct($this->id);

        return $tags;
    }



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
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
}
