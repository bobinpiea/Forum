<?php

/* 
    FICHIER PRINCIPAL DU PROJET : index.php

    Ce fichier est le **point d'entrée unique** du site.
    Il joue le rôle de **chef d'orchestre** :
    
    - Il configure le système (chemins, session, autoloader)
    - Il lit les paramètres dans l’URL (comme ?ctrl=forum&action=login)
    - Il déduit quel **contrôleur** et quelle **méthode** appeler
    - Il exécute cette méthode
    - Il récupère une **vue** (page à afficher)
    - Il l'affiche dans le **layout principal** (template commun)

    Toute page visible par l'utilisateur passe forcément par ici.
*/

/** */

// Endroit ou on va décider de ranger un fichier, et par la suite on ne va plus appeler un fichier physique mais
// un fichier virtuel qui sera sur une étagère virtuelle en l'occurence
// On décide que ce fichier appartient  au namespace "App" - Cela permet de mieux organiser les fichiers PHP par groupes logiques
namespace App;

// DS (Directory Separator) permet d’écrire des chemins compatibles Windows/Linux
define('DS', DIRECTORY_SEPARATOR); // le caractère séparateur de dossier (/ ou \) 
// meilleure portabilité sur les différents systêmes.
define('BASE_DIR', dirname(__FILE__).DS); // pour se simplifier la vie. -  constante magique PHP qui représente le chemin d'un fichier
define('VIEW_DIR', BASE_DIR."view/");   //le chemin où se trouvent les vues
define('PUBLIC_DIR', "public/");     //le chemin où se trouvent les fichiers publics (CSS, JS, IMG)

// Cela signifie : si l’URL ne précise rien (index.php sans paramètres), on appellera HomeController.php
define('DEFAULT_CTRL', 'Home');//nom du contrôleur par défaut 
// Elle contient l’adresse email de l’admin du site :  pourrait servir pour des contacts, des alertes, ou de la modération par exemple 
define('ADMIN_MAIL', "admin@gmail.com");//mail de l'administrateur


// On importe la classe Autoloader pour pouvoir l'utiliser ensuite
require("app/Autoloader.php");

// On enregistre la fonction d'autoload pour charger automatiquement les classes utilisées
Autoloader::register();

//démarre une session ou récupère la session actuelle
// Une session permet de stocker des informations (comme un utilisateur connecté, un message d’erreur, etc.) tant que l’utilisateur reste sur le site.
session_start();
//et on intègre la classe Session qui prend la main sur les messages en session ( et qui se trouve dans App - Session)
use App\Session as Session;

//---------REQUETE HTTP INTERCEPTEE-----------

/*
    Cette section du code intercepte les informations contenues dans l'URL (ex: ?ctrl=forum&action=listTopicsByCategory&id=3) :
    - quel contrôleur instancier (ex: ForumController ou HomeController)
    - quelle méthode du contrôleur appeler (ex: listTopicsByCategory)
    - et avec quel identifiant (ex: id=3)

    Cela permet de centraliser toutes les requêtes dans le fichier index
    et de diriger automatiquement l'utilisateur vers la bonne logique métier.
*/

// On commence par définir le nom du contrôleur à utiliser
// Par défaut, ce sera le contrôleur "Home" (page d'accueil)
$ctrlname = DEFAULT_CTRL;//on prend le controller par défaut 

// Mais si un contrôleur est précisé dans l'URL (ex: ?ctrl=forum),
// alors on utilise le nom de ce contrôleur à la place de "Home"
if(isset($_GET['ctrl'])){ 
    $ctrlname = $_GET['ctrl']; // = Si l’URL contient une information nommée “ctrl”, alors on met sa valeur dans la variable $ctrlname.
}
//on construit le namespace de la classe Controller à appeller
$ctrlNS = "controller\\".ucfirst($ctrlname)."Controller";
//on vérifie que le namespace pointe vers une classe qui existe
if(!class_exists($ctrlNS)){
    //si c'est pas le cas, on choisit le namespace du controller par défaut
    $ctrlNS = "controller\\".DEFAULT_CTRL."Controller"; // ça sera HomeController ds ce cas
}
// On instancie dynamiquement la classe du contrôleur demandé dans l’URL (ex: ForumController)
// Le nom complet de la classe est contenu dans $ctrlNS
// Cela nous permet ensuite d'appeler la bonne méthode du contrôleur plus bas
$ctrl = new $ctrlNS();

$action = "index";//action par défaut de n'importe quel contrôleur
//si l'action est présente dans l'url ET que la méthode correspondante existe dans le ctrl
if(isset($_GET['action']) && method_exists($ctrl, $_GET['action'])){
    //la méthode à appeller sera celle de l'url
    $action = $_GET['action'];
} 
if(isset($_GET['id'])){
    $id = $_GET['id'];
} // sinon on initialise $id à null (aucun identifiant transmis)
else $id = null;
//ex : HomeezController->users(null)
$result = $ctrl->$action($id); 

/*--------CHARGEMENT PAGE--------*/


// C'est quoi ajax ? 
//une technique pour envoyer une requête sans recharger la page entière.

if($action == "ajax"){ //si l'action était ajax
    //on affiche directement le return du contrôleur (càd la réponse HTTP sera uniquement celle-ci)
    echo $result;
}
else{
    ob_start();//démarre un buffer (tampon de sortie)
    $meta_description = $result['meta_description'];
    /* la vue s'insère dans le buffer qui devra être vidé au milieu du layout */
    include($result['view']);
    /* je place cet affichage dans une variable */
    $page = ob_get_contents();
    /* j'efface le tampon */
    ob_end_clean();
    /* j'affiche le template principal (layout) */
    include VIEW_DIR."layout.php";
}