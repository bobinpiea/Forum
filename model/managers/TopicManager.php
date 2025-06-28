<?php
namespace Model\Managers;

// on importe les classes nécessaires
use App\Manager;
use App\DAO;

// cette classe sert à gérer tout ce qui concerne les topics
    class TopicManager extends Manager{

        // on lie cette classe à l'entité Topic (POO)
        protected $className = "Model\Entities\Topic";

        // on indique aussi à quelle table SQL cela correspond
        protected $tableName = "topic";

        // constructeur : on appelle la méthode connect() de la classe parente Manager
        public function __construct(){
            parent::connect();
        }

    // méthode personnalisée pour récupérer les topics d’une catégorie spécifique
public function findTopicsByCategory($id) {

    /*
        On écrit la requête SQL qui :
        - sélectionne tous les champs de la table topic (t.*)
        - récupère en plus le pseudo (nickName) de l’utilisateur lié à chaque topic
        - fait une jointure entre la table topic et la table user
             grâce à t.user_id = u.id_user
        - filtre les résultats pour ne garder que les topics de la bonne catégorie
    */
    $sql = "SELECT t.*, u.nickName 
            FROM " . $this->tableName . " t 
            INNER JOIN user u ON t.user_id = u.id_user 
            WHERE t.category_id = :id";

    /*
        On exécute cette requête SQL avec la méthode DAO::select()
        - on passe le paramètre :id avec la vraie valeur de $id
        - on utilise getMultipleResults car on attend plusieurs résultats (plusieurs topics)
        - on précise le nom de la classe POO à instancier pour chaque résultat : Topic
    */
    return $this->getMultipleResults(
        DAO::select($sql, ['id' => $id]),
        $this->className
    );
}


    }