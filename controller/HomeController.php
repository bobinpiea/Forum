<?php

/************************************************************
 * Ce fichier représente le **HomeController** du projet.
 * Il s’agit du contrôleur par défaut du site.
 * 
 * Son rôle :
 * - gérer la page d'accueil (fonction `index`)
 * - afficher la liste des utilisateurs (fonction `users`)
 * 
 * Ce contrôleur hérite de la classe `AbstractController`
 * ce qui lui permet d’avoir accès à des outils comme 
 * les redirections ou la vérification des rôles.
 ************************************************************/

namespace Controller; // Il indique dans quel dossier virtuel se trouve le fichier

use App\Session; // Sert à gérer les messages en session (ex : erreurs ou succès)
use App\AbstractController; // Permet d’utiliser les méthodes utiles communes à tous les contrôleurs
use App\ControllerInterface; // Force à avoir certaines méthodes de base
use Model\Managers\UserManager; // Pour accéder aux utilisateurs dans la BDD
use Model\Managers\TopicManager; // (non utilisé ici mais importé au cas où)
use Model\Managers\PostManager; // (non utilisé ici mais importé au cas où)

class HomeController extends AbstractController implements ControllerInterface {

    // Cette méthode est celle qui s’exécute par défaut (page d'accueil)
    public function index(){
        return [
            "view" => VIEW_DIR."home.php", // il renvoie vers la vue qui se trouve dans /view/home.php
            "meta_description" => "Page d'accueil du forum" // il ajoute une phrase descriptive pour la balise meta <head>
        ];
    }
        
    // Cette méthode permet d’afficher la liste des utilisateurs du forum
    public function users(){
        $this->restrictTo("ROLE_USER"); // Il vérifie que seul un utilisateur connecté peut voir cette page

        $manager = new UserManager(); // Il crée un nouvel objet pour accéder aux utilisateurs dans la BDD
        $users = $manager->findAll(['register_date', 'DESC']); // Il récupère tous les utilisateurs, triés par date d’inscription, du plus récent au plus ancien

        return [
            "view" => VIEW_DIR."security/users.php", // Il renvoie vers la page qui affiche tous les utilisateurs
            "meta_description" => "Liste des utilisateurs du forum", // Petite description qui sert pour le SEO dans la balise <meta>
            "data" => [  // Il prépare les données à envoyer à la vue
                "users" => $users // Il envoie la liste des utilisateurs pour qu’elle soit affichée dans le fichier users.php
            ]
        ];
    }
}