<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class Tag extends CoreModel {

    /**
     * le nom du tag
     * @var string
     */
    private $name;

    
     /**
     * Méthode permettant de récupérer un enregistrement de la table Tag en fonction d'un id donné
     *
     * @param int $tagId ID du tag
     * @return Tag
     */
    public static function find($tagId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `tag` WHERE `id` =' . $tagId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        // self::class permet d'afficher le FQCN (nom complet) de la classe dans laquelle on se situe
        $tag = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $tag;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     *
     * @return Tag[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `tag`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    /**
     * Méthode qui retrouve des tags selon l'ID d'un produit
     *
     * @param int $productId
     * @return Tag[]
     */
    public static function findByProduct($productId)
    {
        $pdo = Database::getPDO();

        // On crée la requete qui récupère tous les tags liés à un produit dont l'id est transmis en paramètre
        $sql = "SELECT `tag`.* FROM `tag`
                INNER JOIN `product_has_tag`  ON `tag`.`id` = `product_has_tag`.`tag_id`
                WHERE `product_id` = :product_id
                ";

        // Version avec requete imbriquée
        // $sql = "SELECT * from `tag`
        //         WHERE `id` IN (
        //             SELECT `tag_id` FROM `product_has_tag` 
        //             WHERE `product_id` = 11
        //         );";

        $pdoStatement = $pdo->prepare($sql);

        // On remplit l'emplacement avec l'id du produit
        $pdoStatement->bindValue(':product_id', $productId);

        // On exécute la requete
        $pdoStatement->execute();

        // On traduit le résultat de la requete sous forme d'un tableau d'objets de type Tag
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }

    public function insert()
    {
        echo "Méthode insert à coder";
    }

    public function update()
    {
        echo "Méthode update à coder";
    }

    public function delete()
    {
        echo "Méthode delete à coder";
    }




    /**
     * Get le nom du tag
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set le nom du tag
     *
     * @param  string  $name  le nom du tag
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}