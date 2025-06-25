<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface{

    // LA LISTE DE TOUTES LES CATÉGORIES (page d’accueil du forum)
        public function index() {
        
            // On instancie un objet CategoryManager
            // car CategoryManager est une classe qui permet de se connecter à la base de données
            // pour récupérer toutes les informations concernant les catégories
            // Ce fichier se trouve dans model/managers/CategoryManager.php
            // Et comme cette classe hérite de Manager.php (qui est dans app/), et elle peut utiliser findAll()
                $categoryManager = new CategoryManager();

            // [récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)]
            // On utilise la méthode findAll()
            // Objectif : récupérer TOUTES les catégories qui existent dans la base
            // On les trie ici par nom DESC (ordre alphabétique inversé)
            // Cette méthode est définie dans Manager.php et héritée par CategoryManager
                $categories = $categoryManager->findAll(["name", "DESC"]);

            // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
            // VIEW : On indique que l'affichage va se faire dans le fichier view/forum/listCategories.php
            // META_DESCRIPTION : sert à remplir automatiquement la balise <meta name="description"> (utile pour le SEO)
            // DATA : on envoie à la vue un seul objet : $categories
            // Cela permettrait dans la vue de faire une boucle foreach($categories as $category) pour tout afficher
                return [
                    "view" => VIEW_DIR."forum/listCategories.php",
                    "meta_description" => "Liste des catégories du forum",
                    "data" => [
                        "categories" => $categories
                    ]
                ];
        }

    // LA LISTE DES TOPICS PAR CATÉGORIE
        public function listTopicsByCategory($id) {
            
            // On instancie un objet TopicManager
            // Pourquoi ?
            // Car TopicManager est une classe qui va permettre d’aller chercher dans la base de données
            // toutes les informations liées aux topics
            // Ce fichier se trouve dans le dossier "model" -> fichier TopicManager.php
            // Et comme TopicManager hérite de la class Manager, on hérite automatiquement des fonctions SQL
            // (notamment SELECT * FROM, ...)
                $topicManager = new TopicManager();

            // Idem : on instancie un objet CategoryManager
            // Pourquoi ?
            // Parce qu’on aura besoin de récupérer les infos de la catégorie en question : 
            // On veut afficher AUSSI la catégorie sélectionnée (pas juste ses topics)
            // On veut récupérer ses infos, comme son nom
            // Le fichier CategoryManager.php se trouve aussi dans le dossier "model"
            // Et il hérite aussi de Manager, donc on peut utiliser findOneById()
                $categoryManager = new CategoryManager();

            // On utilise la méthode findOneById($id)
            // Objectif : récupérer UNE SEULE catégorie (via son ID)
            // Cette méthode vient de Manager.php (dans app/)
            // Elle est héritée par CategoryManager ainsi on peut l’utiliser ici
                $category = $categoryManager->findOneById($id);

            // On utilise une méthode PLUS SPÉCIFIQUE : findTopicsByCategory($id)
            // Cette méthode se trouve DANS TopicManager.php (model/managers/)
            // Elle permet de récupérer TOUS les topics (qui ont un id_category = $id)
            // Donc tous les topics liés à la catégorie sélectionnée
                $topics = $topicManager->findTopicsByCategory($id);

            // On retourne les informations à la vue (liste des topics) - mais ça peut-être la vue qu'on souhaite
            // VIEW : On précise le chemin du fichier PHP de la vue (dans view/forum/listTopics.php dans ce cas)
            // META_DESCRIPTION => utilisé dans le <head> de la page, pour le référencement
            // DATA : on transmet à la vue deux objets : $category et $topics (ceux qu'on a créé plus haut)
            // - $category => pour afficher le nom ou l’ID de la catégorie
            // - $topics => pour faire une boucle et afficher chaque topi
            return [
                "view" => VIEW_DIR."forum/listTopics.php", 
                "meta_description" => "Liste des topics de la catégorie : ".$category->getName(),
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }
    
    // Detail topic 
        public function detailTopic($id) {

            // On instancie un objet à partir de la classe TopicManager
            // => Cela permet d'utiliser ses méthodes pour récupérer les données sur le topic
                $topicManager = new TopicManager();

            // Même principe : on instancie MessageManager pour récupérer les messages du topic
                $messageManager = new MessageManager();
            
            // On récupère le topic correspondant à l'ID transmis dans l'URL
            // => findOneById() est définie dans Manager.php (héritée par TopicManager)
                $topic = $topicManager->findOneById($id);

            // On récupère tous les messages associés à ce topic
            // => Grace à une méthode personnalisée définie ds MessageManager
                $messages = $messageManager->findMessagesByTopic($id);
            
            // On retourne les données vers la vue detailTopic.php avec :
            // - le topic à afficher
            // - les messages liés à ce topic
            // - une description pour le <meta>
                return [
                    "view" => VIEW_DIR . "forum/detailTopic.php",
                    "meta_description" => "Détail du topic : " . $topic->getTitle(),
                    "data" => [
                        "topic" => $topic,
                        "messages" => $messages
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
        $topicManager = new TopicManager();

        // 
        $topicManager->add([
            "title" => $title,
            "category_id" => $id
        ]);

        $this->redirectTo("forum", "listTopicsByCategory", $id);
    }

    //  AJOUTER UN TOPIC
        public function addTopic($id) {
            return [
                "view" => VIEW_DIR."forum/addTopic.php",
                "meta_description" => "Formulaire d'ajout de topic",
                "data" => [
                    "category_id" => $id
                ]
            ];
        }


        public function deleteTopic($id){

    $topicManager = new TopicManager(); 

    $topic = $topicManager->findOneById($id); 

    $categoryId = $topic->getCategory()->getId();

    $topicManager->delete($id);

    $this->redirectTo("forum", "listTopicsByCategory", $categoryId);
}

}