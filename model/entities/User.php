<?php
// On place cette classe dans le namespace Model\Entities, qui contient toutes les entités du projet.
namespace Model\Entities;

// On importe la classe Entity, qui est une classe utilitaire du projet pour 
// hydrater les objets (c’est-à-dire remplir automatiquement les attributs).
use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, 
    c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. 
    En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

// Ici on déclare la classe "User" qui représente un utilisateur du site.
// Elle est déclarée comme "final", donc elle ne pourra pas être étendue.
final class User extends Entity{

    // Il s’agit des propriétés privées de l’utilisateur : son id et son surnom (nickname)
    private $id;
    private $nickName;
    private $password;
    private $creationDate;
    private $role;
    private $email;
    private $avatar;

    // Quand on crée un objet User, on lui passe un tableau de données $data.
    // Grâce à l'hydratation (qui vient de la classe parente Entity), on remplit automatiquement les attributs de l’objet.
    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        // On stocke la valeur de l’identifiant dans l’attribut $id
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($nickName){
        // On stocke le pseudo dans la propriété $nickName
        $this->nickName = $nickName;
        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(){
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate(){
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate){
        // On stocke la date de création dans la propriété $creationDate
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole(){
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role){
        
        $this->role = $role;
        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email){

        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar(){
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar){
       
        $this->avatar = $avatar;
        return $this;
    }

    // Cette méthode spéciale permet de convertir automatiquement l’objet en chaîne de caractères quand on l'affiche.
    public function __toString() {
        return $this->nickName;
    }
}