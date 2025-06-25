<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;

class ForumController extends AbstractController implements ControllerInterface{

        public function index() {
            
            // créer une nouvelle instance de CategoryManager
            $categoryManager = new CategoryManager();
            // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
            $categories = $categoryManager->findAll(["name", "DESC"]);

            // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "meta_description" => "Liste des catégories du forum",
                "data" => [
                    "categories" => $categories
                ]
            ];
        }

    // Liste des topics par Category

    /*
        public function listTopicsByCategory($id) {

            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();

            // Ici, on recupère l'id et par ricochet le nom de la catégorie
            $category = $categoryManager->findOneById($id);
            // et ici l'id et le nom de la catégorie
            $topics = $topicManager->findTopicsByCategory($id);

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "meta_description" => "Liste des topics par catégorie : ".category->getName(),
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }
        
    */


    // Detail topic 
        public function detailTopic($id) {

            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            $topic = $topicManager->findOneById($id);

                //
                $messages = $messageManager->findMessagesByTopic($id);
                // 
                return [
                    "view" => VIEW_DIR . "forum/detailTopic.php",
                    "meta_description" => "Détail du topic : " . $topic->getTitle(),
                    "data" => [
                        "topic" => $topic,
                        "messages" => $messages
                    ]
                ];
            
        }



        public function listTopicsByCategory($id) {
   
            $topicManager = new \Model\Managers\TopicManager();

        
            $categoryManager = new \Model\Managers\CategoryManager();

        
            $category = $categoryManager->findOneById($id);

        
            $topics = $topicManager->findTopicsByCategory($id);

            return [
                "view" => VIEW_DIR."forum/listTopics.php", 
                "meta_description" => "Liste des topics de la catégorie : ".$category->getName(),
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }

    // A REVOIR

        public function listMessagesByTopic($id) {
            // création d'un objet pour gérer tous les messages
            $messageManager = new MessageManager();
            // Idem pour les topics
            $topicManager = new TopicManager();

            $topic = $topicManager->findOneById($id);
            $messages = $messageManager->findMessagesByTopic($id);


            return [
                "view" => VIEW_DIR."forum/listMessages.php",
                "meta_description" => "Liste des messages par topic : ".$topic,
                "data" => [
                    "topic" => $topic,
                    "messages" => $messages
                ]
            ];
        }

    //  Fonction pour des ajouts de catégorie
        public function addCategory() {

            // Filtre de name pour etre sur de recevoir ce l'on souhaite
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si un nom a bien été envoyé 
            if ($name) {
                // On instancie un objet avec la class de la table CategoryManager 
                // (c'est celle qui se connecte à la bdd et a Category)
                $categoryManager = new CategoryManager();

                // 
                $categoryManager->add(["name" => $name]);

                // On décide de redigirer vers la liste des catégories 
                $this->redirectTo("forum", "index.php");
            }

          
            return [
                "view" => VIEW_DIR."forum/addCategory.php",
                "meta_description" => "Formulaire d'ajout de catégorie"
            ];
        } 
    
    //  Fonction Suppression d'une categorie
        Public function deleteCategory($id) {
           
            // Idem que plus haut, on instancie un objet afin d'avoir accès à la base de données
            $categoryManager = new CategoryManager();

             // On appelle la méthode delete() du Manager (déjà définie dans App\Manager)
            $categoryManager->delete($id);

            $this->redirectTo("forum", "index.php");
            
        }

    // 
        public function addTopicToCategory($id) {
        // 
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        
        // 
        $topicManager = new \Model\Managers\TopicManager();

        // 
        $topicManager->add([
            "title" => $title,
            "category_id" => $id
        ]);

        $this->redirectTo("forum", "listTopicsByCategory", $id);
    }

public function addTopic($id) {
    return [
        "view" => VIEW_DIR."forum/addTopic.php",
        "meta_description" => "Formulaire d'ajout de topic",
        "data" => [
            "category_id" => $id
        ]
    ];
}


}