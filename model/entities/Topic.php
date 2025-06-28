<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, 
    c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut 
    pas être utilisée comme classe parente.
*/

final class Topic extends Entity{

    private $id;
    private $title;
    private $creationDate;
    private $closed;
    private $category_id;
    private $user_id;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
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
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(){
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title){
        $this->title = $title;
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
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Get the value of closed
     */ 
    public function getClosed(){
        return $this->closed;
    }

    /**
     * Set the value of closed
     *
     * @return  self
     */ 
    public function setClosed($closed){
        $this->closed = $closed;
        return $this;
    }

    /**
     * Get the value of category_id
     */ 
    public function getCategoryId(){
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategoryId($category_id){
        $this->category_id = $category_id;
        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId(){
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($user_id){
        $this->user_id = $user_id;
        return $this;
    }

    public function __toString(){
        return $this->title;
    }

    // On récupère ici le pseudo de l’utilisateur créateur du topic
private $nickName;

/**
 * Get the value of nickName (le pseudo de l’auteur du topic)
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
    $this->nickName = $nickName;
    return $this;
}

}