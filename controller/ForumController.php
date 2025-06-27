<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;
use Model\Managers\UserManager;

// On déclare la classe ForumController

// Cette dernière regroupe toutes les méthodes 
// liées à la gestion du forum (affichage des catégories, 
// des topics, des messages, création, suppression ....)

// Elle est déclarée à l’aide du moclt é "class" :
// Un classe est un plan de construction pour créer des objets
// Elle regroupe des variables (attributs) et des fonctions (méthodes)

// ---------- EXTENDS : HÉRITAGE DE LA CLASSE ABSTRAITE ----------

// Le mot clé "extends AbstractController" signifie que cette classe 
// hérite d’une autre classe nommée "AbstractController".

// Cela veut dire que ForumController récupère automatiquement tout ce qui est défini
//  dans la classe AbstractController (méthodes, propriétés, constantes ...)

// Cela permet d’éviter de répéter dans chaque contrôleur les méthodes de base cf.  Cours POO et/ou la doc.

// C’est ce qu’on appelle l’héritage
// L’héritage permet de créer des classes enfants à partir de classes parents
// Cela favorise la réutilisation du code et la structure du projet autre part 

// La classe AbstractController est qualifiée d’abstract
// Une classe abstraite ne peut pas être instanciée
// Elle sert uniquement de modèle de base  pour d’autres classes qui vont l’étendre


// ---------- IMPLEMENTS : UTILISATION D’UNE INTERFACE ----------


// Le mot-clé "implements ControllerInterface" signifie que ForumController
// s’engage à respecter un contrat défini par l’interface ControllerInterface

// Une interface en PHP est une sorte de contrat :
//Elle définit les noms de méthodes que TOUTES les classes qui l’implémentent doivent posséder
// Cela garantit que tous les contrôleurs du projet partagent une structure commune,
// même si leur contenu interne est différent 

// ---------- Différence entre "extends" et "implements" : ----------
// - "extends" permet d’hériter du contenu d’une classe ( existant)
// - "implements" impose de respecter une structure (sans code fourni)



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
            // On les trie ici par nom DESC (ordre alphabétique inversé) - DESCENDANT 
            // Cette méthode est définie dans Manager.php et héritée par CategoryManager
                $categories = $categoryManager->findAll(["name", "DESC"]);

            // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories cf. (data)
            // VIEW : On indique que l'affichage va se faire dans le fichier view/forum/listCategories.php
            // META_DESCRIPTION : sert à remplir automatiquement la balise <meta name="description"> (utile pour le SEO)
            // DATA : on envoie à la vue un seul objet : $categories
            // Cela permettra dans la vue de faire une boucle foreach($categories as $category) pour tout afficher
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
            // toutes les informations liées aux topics "d'ou le nom " List Topics By Category"
            // Ce fichier se trouve dans le dossier "model" via fichier TopicManager.php
            // Et comme TopicManager hérite de la class Manager, on hérite automatiquement des fonctions SQL
            // (notamment SELECT * FROM, ...)
                $topicManager = new TopicManager();

            // Idem : on instancie un objet CategoryManager
            // Pourquoi donc ?
            // Parce qu’on aura besoin de récupérer les infos de la catégorie en question : 
            // On veut afficher AUSSI la catégorie sélectionnée (pas juste ses topics)
            // On veut récupérer ses infos, comme son nom ... 
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
            // Elle permet de récupérer TOUS les topics (qui ont un id_category = $id) ????
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
    
    // DETAIL TOPIC 
        public function detailTopic($id) {

            // On instancie un objet à partir de la classe TopicManager
            // Cela permet d'utiliser ses méthodes pour récupérer les données sur le topic
                $topicManager = new TopicManager();

            // idem : on instancie MessageManager pour récupérer les messages du topic
                $messageManager = new MessageManager();
            
            // On récupère le topic correspondant à l'ID 
            // findOneById() est définie dans Manager.php (héritée par TopicManager)
                $topic = $topicManager->findOneById($id);

            // On récupère tous les messages associés à ce topic
            // Grace à une méthode personnalisée définie ds MessageManager
                $messages = $messageManager->findMessagesByTopic($id);
            
            // On retourne les données vers la vue detailTopic.php (à créer) avec :
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
    // METHODE POUR AFFICHER TOUS LES MESSAGES D'UN TOPIC
        public function listMessagesByTopic($id) {
            // CREATION DES OBJETS VIA LES MANAGERS 
            // création d'un objet pour gérer tous les messages
                $messageManager = new MessageManager();
            // Idem pour les topics
                $topicManager = new TopicManager();

            // Récupération du topic 
            $topic = $topicManager->findOneById($id);
            // Récupération des messages 
            $messages = $messageManager->findMessagesByTopic($id);

            // Retour à la vue 
            return [
                "view" => VIEW_DIR."forum/listMessages.php",
                "meta_description" => "Liste des messages par topic : ".$topic,
                "data" => [
                    "topics" => $topic,
                    "messages" => $messages
                ]
            ];
        }

    //  AJOUTER UNE NOUVELLE CATÉGORIE AU FORUM
        public function addCategory() {

            // Filtrage de la donnée entrante: de name pour être sur de recevoir ce que l'on souhaite
            //
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si un nom a bien été envoyé 
            if ($name) {
                // On instancie un objet avec la class de la table CategoryManager 
                // (c'est celle qui se connecte à la bdd et à Category)
                $categoryManager = new CategoryManager();

                // On utilise la méthode add() pour insérer une nouvelle ligne dans la table category
                $categoryManager->add(["name" => $name]);

              // Ici, on redirige le nvagitaeur vers une page du site 
              // redirectTo() est une méthode définie dans AbstractController (le fichier parent de ForumController)
                $this->redirectTo("forum", "index.php");
            }
          
            //  si rien n’a été envoyé (ou que le formulaire est vide), on affiche le formulaire à nouveau 
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

            return [
                "view" => VIEW_DIR."forum/listCategories.php", // on renvoie vers la vue qui liste les catégories
                "meta_description" => "Liste des catégories du forum après suppression", // description pour le <head>
                "data" => [
                    "categories" => $categories // on transmet la nouvelle liste des catégories
                ]
            ];  
        }


    //  AJOUTER UN NOUVEAU TOPIC À UNE CATÉGORIE
        public function addTopicToCategory($id) {
            //  On récupère le champ "title" envoyé par formulaire en POST qu'on enverra dans la table Topic
            // filter_input permet de sécuriser ce qu’on reçoit
            //Objectif
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            
            // Interaction avec la bdd et ici la table topic
                $topicManager = new TopicManager();

            // On utilise la méthode add() pour insérer un nouveau topic dans la bdd
            // On lui passe un tableau associatif avec :
            // - "title" => le titre du topic 
            // - "category_id" => l ID de la catégorie dans laquelle ajouter ce topic
                $topicManager->add([
                    "title" => $title,
                    "category_id" => $id,
                    "user_id" => 1,
                ]);

            // Une fois que le topic est ajouté, on fait une redirection 
            
                $this->redirectTo("forum", "listTopicsByCategory", $id);

             // Si  rien n'a été rransmis, on retourne la vue du formulaire 
                return [
                    "view" => VIEW_DIR . "forum/addTopic.php",
                    "meta_description" => "Formulaire d'ajout de topic",
                      "data" => [
                    "category_id" => $id
                    ]   
                ];
        }

    
    // 
        public function deleteTopic($id){

            $topicManager = new TopicManager(); 

            $topic = $topicManager->findOneById($id); 

            $categoryId = $topic->getCategory()->getId();

            $topicManager->delete($id);

            $this->redirectTo("forum", "listTopicsByCategory", $categoryId);
        }

    
    //
        public function addMessageToTopic($id) {

            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $userId = 1;

            $messageManager = new MessageManager();

            $messageManager->add([
                "content" => $content,
                "topic_id" => $id,
                "user_id" => $userId
            ]);

            $this->redirectTo("forum", "detailTopic", $id);
        }

    // SUPPRESSION D’UN MESSAGE 
        public function deleteMessage($id) {

            // On instancie un objet MessageManager
            // car MessageManager est une classe qui permet de se connecter à la base de données
            // pour interagir avec les messages (table "message" dans la base de données)
            // Ce fichier se trouve dans model/managers/MessageManager.php
            // Et comme cette classe hérite de Manager.php (présent dans app/), elle peut utiliser toutes les méthodes comme findOneById() ou delete()
            $messageManager = new MessageManager();

            // Récupération du message via son id 
            // La méthode findOneById($id) permet d’aller chercher dans la bdd id mi sen paramètre 
            // le message récupéré est dans l'objet $message
            $message = $messageManager->findOneById($id);

            // Récupération de l’ID du topic associé à ce message
            // Objectif : pouvoir rediriger l’utilisateur vers la page du topic après la suppression du message
            // On utilise ici deux méthodes en chaîne :
            // -> getTopic() : permet de récupérer l’objet Topic lié à ce message
            // -> getId() : permet d’obtenir uniquement l’identifiant (numérique) du topic
            // Résultat : on obtient par exemple un entier comme 7 ou 12 qui correspond à l’ID du sujet
            $topicId = $message->getTopic()->getId();

            // Suppression du message dans la base de données
            // On utilise ici la méthode delete($id) définie dans Manager.php
            // Cette méthode exécute une requête DELETE SQL pour supprimer définitivement le message dont l’ID est donné
            $messageManager->delete($id);

            // Redirection vers la page du topic associé après suppression
            // Objectif : revenir automatiquement à la page du sujet une fois le message supprimé
            // La méthode redirectTo() permet de rediriger vers une autre action d’un contrôleur
            // Ici, on redirige vers : controller = "forum", action = "detailTopic", et on transmet l’ID du topic pour l'affichage
            $this->redirectTo("forum", "detailTopic", $topicId);
        }


}



 