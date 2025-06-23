<?php
namespace App;

/*  DEFINITION : 
    En programmation orientée objet, une classe abstraite est une classe qui ne peut pas être instanciée directement. 
    Cela signifie que vous ne pouvez pas créer un objet directement à partir d'une classe abstraite.
    Les classes abstraites : 
    -- peuvent contenir à la fois des méthodes abstraites (méthodes sans implémentation) et 
    des méthodes concrètes (méthodes avec implémentation).
    -- peuvent avoir des propriétés (variables) avec des valeurs par défaut.
    -- une classe peut étendre une seule classe abstraite.
    -- permettent de fournir une certaine implémentation de base.
*/

/******************************************************
 Ce fichier contient la classe AbstractController
 C’est une classe de base pour tous les contrôleurs du projet (comme HomeController, ForumController...).
 Elle sert à fournir des outils communs :
 une méthode index()
 une méthode redirectTo() pour rediriger vers une autre page
 une méthode restrictTo() pour limiter l’accès à certains rôles
 
 Tous les autres contrôleurs "étendent" cette classe pour bénéficier de ces outils sans avoir à les réécrire.
 ******************************************************/

abstract class AbstractController{

    // Cette méthode est définie ici juste pour obliger tous les contrôleurs à avoir une méthode index() 
    // (même si elle est vide pour le moment)
    public function index() {}

    // Cette méthode permet de rediriger automatiquement vers une autre page
    // Elle prend en option le nom du contrôleur, de l’action, et d’un identifiant
    public function redirectTo($ctrl = null, $action = null, $id = null){

        // Elle commence par créer une URL vide et ajoute petit à petit les éléments
        $url = $ctrl ? "?ctrl=".$ctrl : ""; // Si on fournit un nom de contrôleur, on ajoute ?ctrl=nom
        $url.= $action ? "&action=".$action : ""; // Si on donne une action, on ajoute &action=nom
        $url.= $id ? "&id=".$id : ""; // Si on donne un id, on ajoute &id=valeur

        header("Location: $url"); // Cette ligne dit au navigateur : “va vers cette URL”
        die(); // et on arrête le script immédiatement après la redirection
    }

    // Cette méthode permet de restreindre une page à un rôle précis (ex : "ROLE_USER" ou "ROLE_ADMIN")
    public function restrictTo($role){
        
        // Si l'utilisateur n'est pas connecté ou qu’il n’a pas le rôle demandé
        if(!Session::getUser() || !Session::getUser()->hasRole($role)){
            // alors on le redirige vers la page de connexion
            $this->redirectTo("security", "login");
        }
        return; // Sinon, on ne fait rien et on continue normalement
    }

}