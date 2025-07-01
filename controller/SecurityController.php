<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;
use Model\Managers\UserManager;
use App\DAO;


use Model\Entities\User;

// contiendra les méthodes liées à l'authentification : register, login, logout ainsi que le profil de l'utilisateur
class SecurityController extends AbstractController{


// LA FONCTION RELATIVE A L'ENREGISTREMENT 
    public function register() {

        // On vérifie que le formulaire a bien été soumis (clic sur le bouton "submit")
        if (isset($_POST["submit"])) {

            // On récupère et on nettoie les données du formulaire, afin d'éviter toute failles XXS
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email    = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $pass1    = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2    = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On vérifie que tous les champs soient bien remplis
            if ($nickName && $email && $pass1 && $pass2) {

                // Vérification que les 2 mots de passe sont identiques et assez longs
                // et a au moins 12 caractères (respect conseil de la CNIL )
                // Je devrais mettre plus Alpanumérique, Maj, Min mais next time
                if ($pass1 === $pass2 && strlen($pass1) >= 3) {

                    //  On instancie la classe UserManager pour pouvoir interagir avec la base de données 
                    // et accéder à toutes les méthodes liées aux utilisateurs
                    // (comme ajouter, chercher, ou supprimer un user)
                    $userManager = new UserManager();

                    // Insertion du nouvel utilisateur
                    $userManager->add([
                        "nickName"      => $nickName,
                        "email"         => $email,
                        "password"      => password_hash($pass1, PASSWORD_DEFAULT),
                        "creationDate"  => date("Y-m-d H:i"),
                        "role"          => "user",
                        "avatar"        => null      
                    ]);

                    // Redirection vers la page de connexion
                    $this->redirectTo("security", "login");

                } else {
                    echo "Les mots de passe ne correspondent pas ou sont trop courts.";
                }

            } else {
                echo "Merci de remplir tous les champs du formulaire.";
            }
        }

        // 
        return [
            "view" => VIEW_DIR . "security/register.php",
            "meta_description" => "Inscription utilisateur"
        ];
    }


// FONCTION RELATIVE A LA CONNEXION   
    public function login() {

        // Cette ligne appelle la méthode statique définie dans notre DAO
        // pour établir une connexion avec la base de donnée, dans le namespace App
        \App\DAO::connect();

        // On vérifie si le formulaire a été soumis 
        if (isset($_POST["submit"])) {

            // On récupère et nettoie les données du formulaire et on les filtres afin d'éviter 
            // toutes failles xxs
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Vérification des deux champs et que les deux champs ont bien été remplis
            if ($email && $password) {

                //var_dump("email"); die;

                // Preparation d'une requete sql pour récupérer l'utilisateur 
                // Eviter toutes injection sql 
                $requete = "SELECT * FROM user WHERE email = :email";

                // On crée un variable dans laquelle il y aura le resulat ou pas de la requete sql 
                // ca sera un tableau associatif  
                // Appelle de la méthode statique Select() de DAO
                // Cette dernière prépare, exécute et renvoie un seul résultat 
                // D'ou le fetch  (false = fetch() )
                $result = DAO::select($requete, ["email" => $email], false); 

                // On vérifie si un utilisateur a été trouvé avec cet email
                // Si un utilisateur est trouvé dans la base de données,
                // on passe à la vérification du mot de passe.
                if ($result) {

                    // On vérifie si le mdp est juste
                    // password_verify compare le mot de passe saisi
                    // avec celui haché stocké dans la base 
                    // si le deux concordent
                    if (password_verify($password, $result["password"])) {

                        // Création d'un objet User avec les données récupérées
                        // et on le garde en mémoire via la super globale (SESSION)
                        // durée la durée de la navigation - et les réutiliser ultérieurement 
                        $_SESSION["user"] = new User($result);

                        // Redirection vers la page d'accueil du forum
                        $this->redirectTo("forum", "listCategories");

                    } else {
                        echo "Mot de passe incorrect";
                    }

                } else {
                    echo "Adresse email incorrect";
                }

            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }

        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Connexion",
        ];
    }

    //
        public function logout () {
            
        // On supprime l'utilisateur stocké dans la session
        // Et cela déconnecte complètement l'utilisateur
        unset($_SESSION["user"]);

        // Redirection vers l’accueil du forum
        $this->redirectTo("forum", ""); 

        }

// Fonction pour afficher l'utilisateur qui est connecté 
    public function profile() {

        // Verification si la personne est connecté ou pas 
        // sinon la diriger vers la page de connexion 
        // :: car on appel une methode dit static 
        if (!Session::getUser()) {
            // redirection pour qu'il se connecte
            $this->redirectTo("security", "login");
        }

        //  s'il est connecté on recupère la session
        $user = Session::getUser();

        // On prépare les données à envoyer à la vue - qui est dans le sous dossier security
        // Chemin vers la vue à afficher 
        // Meta description pou rle SEO

        return [
            "view" => VIEW_DIR."security/profile.php",  
            "meta_description" => "Profil de l'utilisateur", 
            "data" => [
                "user" => $user   
            ]
        ];
    }


    public function editProfile (){

        //Qd il est connecté, on recupère sa session 
        $user = Session::getUser();

         return [
            "view" => VIEW_DIR."security/editprofile.php",  
            "meta_description" => "Editer Profil de l'utilisateur", 
            "data" => [
                "user" => $user   
            ]
        ];
    }


}



