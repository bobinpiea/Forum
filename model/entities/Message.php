<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, 
    c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut 
    pas être utilisée comme classe parente.
*/

final class Message extends Entity{

    private $id;
    private $creationDate;
    private $content;
    private $user_id;
    private $topic_id;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){         
        $this->hydrate($data);        
    }

// GETTEUR ET SETTEUR DE ID

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

    // GETTEUR ET SETTEUR DE CREATION DATE

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

// GETTEUR ET SETTEUR DE GETCONTENT

    /**
     * Get the value of content
     */ 
    public function getContent(){
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content){
        $this->content = $content;
        return $this;
    }

    // GETTEUR ET SETTEUR DE USER_ID

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

    // GETTEUR ET SETTEUR  DE TOPIC_ID

    /**
     * Get the value of topic_id
     */ 
    public function getTopicId(){
        return $this->topic_id;
    }

    /**
     * Set the value of topic_id
     *
     * @return  self
     */ 
    public function setTopicId($topic_id){
        $this->topic_id = $topic_id;
        return $this;
    }

    // TO STRING

    public function __toString(){
        return $this->content;
    }
}