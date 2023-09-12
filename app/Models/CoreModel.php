<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * La méthode save permet d'avoir une méthode unique de sauvegarde de nos objets dans la BDD. Tous les models héritent de cette méthode qui choisit toute seule si on exécute la méthode insert() (pour créer un élément) ou update() (pour modifier un élément). Comme les méthodes update() et insert() sont abstraites, tous les enfants de CoreModel y auront accès !
     *
     * @return void
     */
    public function save()
    {
        if(isset($this->id)){
            // Si l'id est défini,  l'élément existe donc on le met à jour
           return  $this->update();

        }
        else {
            // Sinon, l'élément n'existe pas encore, on l'insère en BDD
            return $this->insert();
        }
    }

    // Le mot clé abstract devant une méthode permet d'indiquer à PHP que tous les enfants de cette classe doivent implémenter cette méthode avec les memes caractéristiques (visibilite, nom, paramètres)
    // Ici on obligé tous les models (et futurs models) à avoir les 5 méthodes du CRUD
    abstract public function insert(); // C
    abstract public static function findAll(); // R
    abstract public static function find($id); // R
    abstract public function update(); // U
    abstract public function delete(); // D



}
