<?php
namespace Model\Managers;

// on importe les classes nécessaires
use App\Manager;
use App\DAO;

// on crée une classe pour gérer les messages
class MessageManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Message";
    protected $tableName = "message"; // Pour moi !!!!! table en minuscule (comme en BDD)

    // constructeur : on se connecte à la base via la classe parente
    public function __construct(){
        parent::connect();
    }

    // méthode personnalisée pour récupérer les messages d’un topic
    public function findMessagesByTopic($id) {
        // Objectif : récupérer tous les messages d’un topic (via son id)

        $sql = "SELECT * 
                FROM ".$this->tableName." m 
                WHERE m.topic_id = :id";

        // il peut y avoir plusieurs messages, donc on utilise getMultipleResults
        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), // on exécute la requête préparée
            $this->className // on indique quelle classe POO instancier
        );
    }
}