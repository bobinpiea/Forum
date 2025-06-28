<?php
namespace Model\Managers;

// on importe les classes Manager et DAO de l'application
use App\Manager;
use App\DAO;

// on crée une classe qui hérite de la classe Manager
class CategoryManager extends Manager{

    // on indique la classe POO (entité) et la table correspondante en base de données
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    // constructeur du manager : on établit la connexion à la BDD en appelant connect() (hérité de Manager)
    public function __construct(){
        parent::connect();
    }
}