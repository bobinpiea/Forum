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

            public function index() { // MODIFIER LES COMMENTAIRES car j'ai changé la redirection 
                
                // On instancie un objet : CategoryManager
                // Pourquoi ? Car CategoryManager est une classe qui permet de se connecter à la base de données
                // pour récupérer toutes les informations concernant les catégories
                // Ce fichier se trouve dans model/managers/CategoryManager.php
                // Et comme cette classe hérite de Manager.php (qui est dans app/), et elle peut utiliser findAll() (qui est une fonction native de PHP)
                    $categoryManager = new CategoryManager();

                // (Récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom) + Ordre Décroissant)
                // On appelle la méthode findAll() héritée de Manager.php
                // Elle permet de récupérer toutes les lignes de la table "category" - "All"
                // On les trie par ordre décroissant (DESC) selon la colonne "name"
                // On obtient un tableau d'objets "Category"
                    $categories = $categoryManager->findAll(["name", "DESC"]);

                // On prépare les données à envoyer à la vue (listCategories.php)
                // C'est un tableau tableau associatif, et ce dernier contient :
                // - le chemin vers le fichier PHP qui affichera la page (view)
                // - une description de la page (meta_description) pour les moteurs de recherche
                // - un tableau de données contenant les catégories récupérées 
                    return [
                        // Chemin vers la vue qui va afficher les catégories (dans view/forum/)
                            "view" => VIEW_DIR."forum/listCategories.php", 
                        // Description de la page, utilisée dans la balise <meta> du <head> HTML
                            "meta_description" => "Liste des catégories du forum", 
                        // Données envoyées à la vue (on y accèdera avec $result["data"]['categories'])
                            "data" => [
                                "categories" => $categories
                            ]
                    ];
            }

    /** FONCTIONS LIEES AUX CATEGRORIES  */   

        // MÉTHODE POUR AFFICHER LA LISTE DES TOPICS PAR CATÉGORIE
            public function listTopicsByCategory($id) {
                
                // On instancie un objet TopicManager
                // Pourquoi ?
                // Car TopicManager est une classe qui va permettre d’aller chercher dans la base de données
                // toutes les informations liées aux topics "d'où le nom" List Topics By Category
                // Ce fichier se trouve dans le dossier/ namespace "model" via fichier TopicManager.php
                // Et comme TopicManager hérite de la class Manager, on hérite automatiquement des fonctions SQL
                // (notamment SELECT * FROM, ...), et aussi de nos méthodes natives comme findTopicsByCategory()
                    $topicManager = new TopicManager();

                // Idem : on instancie un objet CategoryManager
                // Pourquoi donc ?
                // Parce qu’on aura besoin de récupérer les infos de la catégorie en question : 
                // On veut afficher AUSSI la catégorie sélectionnée (pas juste ses topics)
                // On veut récupérer ses infos, comme son nom ...
                // Le fichier CategoryManager.php se trouve aussi dans le dossier "model"
                // Et il hérite aussi de Manager, donc on peut utiliser findOneById()
                    $categoryManager = new CategoryManager();

                // On utilise la méthode findOneById($id) qui retourne un objet
                    $category = $categoryManager->findOneById($id);

                // On vérifie si la catégorie existe bien
                // Si elle n'existe pas (ID incorrect, catégorie supprimée...), on redirige vers l'accueil du forum
                    if (!$category) {
                        $this->redirectTo("forum", "index");
                    }

                // On utilise : findTopicsByCategory($id)
                // Cette méthode se trouve DANS TopicManager.php (model/managers/)
                // Elle permet de récupérer TOUS les topics (qui ont un category_id = $id)
                // Donc tous les topics liés à la catégorie sélectionnée
                    $topics = $topicManager->findTopicsByCategory($id);

                // On retourne les informations à la vue (liste des topics) - mais ça peut être la vue qu'on souhaite
                // VIEW : On précise le chemin du fichier PHP de la vue (dans view/forum/listTopics.php dans ce cas)
                // META_DESCRIPTION => utilisé dans le <head> de la page, pour le référencement
                // DATA : on transmet à la vue deux objets : $category et $topics (ceux qu'on a créés plus haut)
                // - $category => pour afficher le nom ou l’ID de la catégorie
                // - $topics => pour faire une boucle et afficher chaque topic
                    return [
                        "view" => VIEW_DIR."forum/listTopics.php", 
                        "meta_description" => "Liste des topics de la catégorie : ".$category->getName(),
                        "data" => [
                            "category" => $category,
                            "topics" => $topics
                        ]
                    ];
            }

        // AFFICHER UN FORMULAIRE POUR AJOUTER UNE NOUVELLE CATEGORIE 
            public function addCategory() {
                // Cette méthode ne fait qu'afficher le formulaire HTML vide permettant
                // à l'utilisateur d'écrire le nom d'une nouvelle catégorie.

                // on ne crée rien, on ne lit rien, on prépare juste l'affichage du formulaire.
                // Le formulaire affiché se trouve dans view/forum/addCategory.php
                // Il sera traité ensuite par une autre méthode qui, qunat à elle, fera l'insertion.
                    return [
                        "view" => VIEW_DIR."forum/addCategory.php",
                        "meta_description" => "Formulaire pour ajouter une catégorie"
                    ];
            }            

        // AJOUTER/INSERER UNE NOUVELLE CATEGORIE
            public function insertCategory() {
                // On vérifie que des données ont été envoyées en POST - Charles
                    if (isset($_POST["name"]) && !empty($_POST["name"])) {

                        // On nettoie la donnée envoyée depuis le formulaire - Afin d'éviter toutes failles - CHARLES 
                            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        // On instancie un objet CategoryManager pour gérer les catégories
                            $categoryManager = new CategoryManager();

                        // On appelle la méthode add() du manager en lui donnant le nom de la nouvelle catégorie
                            $categoryManager->add([
                                "name" => $name
                            ]);

                        // On redirige vers la page d'accueil du forum (liste des catégories)
                            $this->redirectTo("forum", "index");

                    } else {
                        // Si le champ est vide, on peut rediriger vers le formulaire ou afficher une erreur
                        // Pour l’instant, on redirige juste vers la liste des catégories
                            $this->redirectTo("forum", "index");
                    }
            }

    
        //    Fonction Suppression d'une categorie (supprimer une catégorie depuis son identifiant)
    
            public function deleteCategory($id) {

                // Idem que plus haut, on instancie un objet afin d'avoir accès à la base de données
                    $categoryManager = new CategoryManager();

                // On supprime la catégorie dont l'id est celui reçu dans l'URL (grâce à $_GET['id'])
                // On appelle la méthode delete() du Manager (déjà définie dans App\Manager)
                    $categoryManager->delete($id);

                // On retourne vers la liste des catégories, comme si on appelait la méthode index()
                    $this->redirectTo("forum", "index");;
            }

  /** FONCTIONS RELATIVES AUX TOPICS  */   

        // MÉTHODE pour créer un nouveau topic (sujet) dans une catégorie

            public function addTopicToCategory($id) { // Fait par charles - DONC RELIS LE

                // On instancie les managers pour accéder à la base de données
                    $topicManager = new TopicManager();         // Pour insérer un nouveau topic
                    $categoryManager = new CategoryManager();   // Pour récupérer la catégorie actuelle

                // On récupère la catégorie dans laquelle on va créer le topic
                    $category = $categoryManager->findOneById($id);

                // On vérifie si le formulaire a été soumis en regardant si le champ "title" existe - Charles 
                    if (!empty($_POST["title"])) {

                        // On récupère le champ "title" (titre du topic) envoyé par le formulaire
                        // On le nettoie avec filter_input pour éviter les failles XSS
                        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        // Correction ici : on récupère l’ID utilisateur saisi dans le formulaire 
                            $user_id = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_NUMBER_INT);

                        // Si le titre est bien rempli, on peut enregistrer le topic
                            if ($title) {

                            // On ajoute le topic à la base de données avec la méthode add()
                                $topicManager->add([
                                    "title" => $title,                            // Le titre saisi par l'utilisateur
                                    "creationDate" => date("Y-m-d H:i:s"),        // Date et heure actuelle
                                    "closed" => 0,                                // Le topic est "ouvert"
                                    "category_id" => $id,                         // L'identifiant de la catégorie choisie
                                    "user_id" => $user_id                         // L'auteur du topic (récupéré depuis le formulaire)
                                ]);

                            // Une fois le topic ajouté, on redirige vers la liste des topics de cette catégorie
                                $this->redirectTo("forum", "listTopicsByCategory", $id);
                        }
                    }

                    // Si le formulaire n'a pas encore été envoyé, on affiche simplement le formulaire
                        return [
                            "view" => VIEW_DIR."forum/addTopicToCategory.php",                        // Fichier de vue
                            "meta_description" => "Ajouter un topic dans la catégorie ".$category, 
                            "data" => [
                                "category" => $category       // On envoie la catégorie à la vue
                            ]
                        ];
            }


        // MÉTHODE POUR SUPPRIMER UN TOPIC
            public function deleteTopic($id) {

                // On instancie le TopicManager (accès à la table topic)
                    $topicManager = new TopicManager();

                // On récupère le topic AVANT de le supprimer
                // Pourquoi ? Car on a besoin de connaître la catégorie d’origine (pour rediriger ensuite)
                    $topic = $topicManager->findOneById($id);

                // Si le topic existe bien
                    if ($topic) {

                    // On récupère l’ID de la catégorie liée à ce topic
                        $categoryId = $topic->getCategoryId();

                    // On supprime le topic
                        $topicManager->delete($id);

                    // Une fois supprimé, on redirige vers la liste des topics de cette catégorie
                        $this->redirectTo("forum", "listTopicsByCategory", $categoryId);
                }
                else {
                    // Si le topic n'existe pas , on redirige vers le forum général
                        $this->redirectTo("forum", "index");
                }
            }


  /** FONCTIONS RELATIVES AUX MESSAGES  */   

        // MÉTHODE POUR AFFICHER TOUS LES MESSAGES D’UN TOPIC
            public function listMessagesByTopic($id) {

                // Même reflexion, Managers nécessaires
                    $messageManager = new MessageManager();
                    $topicManager = new TopicManager();

                // écupérer le topic (titre, auteur, etc.)
                    $topic = $topicManager->findOneById($id);

                // Si le topic n’existe pas, on redirige vers les topics de la catégorie précédente 
                if (!$topic) {
                    //  ici on ne peut pas récupérer l’ID de la catégorie du topic supprimé - Charles
                    // donc on redirige vers la liste générale des catégories
                    $this->redirectTo("forum", "listCategories");
                }

                // Récupérer les messages associés
                    $messages = $messageManager->findMessagesByTopic($id);

                // On renvoie à la vue
                    return [
                        "view" => VIEW_DIR."forum/listMessages.php",
                        "meta_description" => "Messages du topic : ".$topic,
                        "data" => [
                            "topic" => $topic,
                            "messages" => $messages
                        ]
                    ];
            }

        // MÉTHODE POUR AJOUTER UN MESSAGE DANS UN TOPIC
            public function addMessageToTopic($id) {

                // On instancie le MessageManager
                $messageManager = new MessageManager();

                // On vérifie que le champ "content" existe dans le formulaire
                if (!empty($_POST["content"])) {

                    // On nettoie le contenu du message (anti XSS)
                    $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    // On récupère l’ID utilisateur depuis le formulaire
                    $user_id = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_NUMBER_INT);

                    // Si le contenu est bien rempli
                    if ($content && $user_id && $id) {

                        // On insère le message dans la base
                        $messageManager->add([
                            "content" => $content,
                            "creationDate" => date("Y-m-d H:i:s"),
                            "user_id" => $user_id,
                            "topic_id" => $id
                        ]);

                        // Redirection vers la page du topic
                        $this->redirectTo("forum", "listMessagesByTopic", $id);
                    }
                }

                // Si le formulaire est mal rempli, on redirige quand même vers le topic
                $this->redirectTo("forum", "listMessagesByTopic", $id);
            }

        // MÉTHODE POUR SUPPRIMER UN MESSAGE
            public function deleteMessage($id) {

                // On instancie le manager
                $messageManager = new MessageManager();

                // On récupère le message qu’on veut supprimer (objet Message)
                $message = $messageManager->findOneById($id);

                // On vérifie si le message existe bien
                if ($message) {

                    // On récupère l’identifiant du topic auquel appartient ce message
                    $topicId = $message->getTopicId();

                    // On supprime le message
                    $messageManager->delete($id);

                    // Une fois le message supprimé, on redirige vers la liste des messages du même topic
                    $this->redirectTo("forum", "listMessagesByTopic", $topicId);
                }

                // Si le message n’existe pas, on peut rediriger vers une page d’erreur ou la page d’accueil
                else {
                    $this->redirectTo("forum", "listCategories");
                }
            }


    }