<?php
namespace Model\Managers;


use App\Manager;
use App\DAO;


class MessageManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Message";
    protected $tableName = "Message";

    public function __construct(){
        parent::connect();
    }


    public function findMessagesByTopic($id) {
     //Objectif recupérer les messages    
    // Inner join ou pas ??????
        $sql = "SELECT * 
                FROM ".$this->tableName." m 
                WHERE m.topic_id = :id";

    // Il y a plusieurs message dès lors -> getMultipleResults
    return $this->getMultipleResults(
        DAO::select($sql, ['id' => $id]),
        $this->className
    );
}





}