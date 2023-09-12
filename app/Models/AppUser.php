<?php

namespace App\Models;


use PDO;
use App\Utils\Database;

// Model représentant la table app_user dans la BDD
class AppUser extends CoreModel {


    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;


    public function insert()
    {
         // Récupération de l'objet PDO représentant la connexion à la DB
         $pdo = Database::getPDO();

         // Ecriture de la requête INSERT INTO
         // Pour se protéger des injections SQL notre requete doit comporter des "emplacements". Des sortes de cases dans lesquelles on mettra les vraies valeurs plus tard.
         // Par convention, un emplacement commence par ":" et porte le nom du champ.
         $sql = "INSERT INTO `app_user` 
         (`email`, `password`, `firstname`, `lastname`, `role`, `status`)
         VALUES (:email, :password, :firstname, :lastname, :role, :status)
         ";
 
         // Une fois la requete créée, on la confie à PDO pour qu'il prenne connaissance de celle-ci.
         $pdoStatement = $pdo->prepare($sql);
 
         // Maintenant qu'il sait que la requete est une requete INSERT INTO qui contient 3 emplacements, on les remplit avec nos valeurs
         $pdoStatement->bindValue(':email', $this->email);
         $pdoStatement->bindValue(':password', $this->password);
         $pdoStatement->bindValue(':firstname', $this->firstname);
         $pdoStatement->bindValue(':lastname', $this->lastname);
         $pdoStatement->bindValue(':role', $this->role);
         $pdoStatement->bindValue(':status', $this->status);
 
 
         // On exécute la requete préparée à l'aide de la méthode execute
         $success = $pdoStatement->execute();
 
         // Si la requete a fonctionné
         if ($success) {
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
     * Méthode récupérant tous les utilisateurs
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
       
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    public static function find($userId)
    {
        echo "Appel de la méthode qui trouve un utilisateur";

        // TODO : coder cette méthode
    }

    public static function findByEmail($email)
    {

        $pdo = Database::getPDO();

        // On fait notre requete de récupération d'un utilisateur d'après son email. Comme l'email provient de l'extérieur, on prépare la requete pour éviter les injections
        $sql = "SELECT * FROM `app_user`
        WHERE `email` = :email";

        // On prépare la requete
        $pdoStatement = $pdo->prepare($sql);

        // On lui donne la valeur de l'email à insérer
        $pdoStatement->bindValue(':email', $email);

        // On envoie  la requete à la BDD avec execute
        $pdoStatement->execute(); 

        // L'objet pdoStatement contient la réponse de la BDD. On doit donc la traduire sous la forme d'un objet de type AppUser (la classe courante)
        $user = $pdoStatement->fetchObject(self::class);

        return $user;

        
    }

    public function update()
    {
        echo "Appel de la méthode de mise à jour d'utilisateur";

        // TODO : coder cette méthode
    }

    public function delete()
    {
        echo "Appel de la méthode de suppression d'utilisateur";
        // TODO : coder cette méthode
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}