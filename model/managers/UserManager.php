<?php
// On déclare le namespace (le dossier virtuel où se trouve la classe)
namespace Model\Managers;

// On importe la classe Manager et la classe DAO (pour les connexions à la base de données)
use App\Manager;
use App\DAO;

// Cette classe gère toutes les requêtes SQL liées aux utilisateurs
// Elle hérite de la classe Manager qui contient les fonctions de base (findAll, findOneById, etc.)
class UserManager extends Manager{

  
    // A mieux comprendre !!!!
    protected $className = "Model\\Entities\\User";
    // On indique aussi à ce manager avec quelle table de la base il doit travailler
    // Ici : la table 'user'
    protected $tableName = "user"; 

    // Quand on crée un UserManager, on appelle le constructeur de la classe parent (Manager)
    // Ce constructeur va connecter à la base de données (grâce à parent::connect())
    public function __construct(){
        parent::connect();
    }
}