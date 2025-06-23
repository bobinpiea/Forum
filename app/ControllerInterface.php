<?php
namespace App;

/*
    En programmation orientée objet, une interface est un concept qui permet de définir
    un contrat comportemental qu'une classe doit suivre. 
    Une interface en POO ne contient que des signatures de méthodes (méthodes sans implémentation), 
    mais ne fournit pas d'implémentation concrète. Elle définit simplement la structure que les classes 
    qui implémentent cette interface doivent respecter.

    Les classes abstraites :
    -- ne peuvent contenir que des signatures de méthodes (méthodes sans implémentation).
    -- ne peuvent pas avoir de propriétés avec des valeurs par défaut 
        (jusqu'à PHP 8.0, où les propriétés peuvent être déclarées, mais sans valeurs par défaut).
    -- une classe peut implémenter plusieurs interfaces.
    -- fournissent une forme de contrat où les classes qui implémentent une interface doivent 
        fournir une implémentation pour toutes les méthodes déclarées dans l'interface.
*/

/****************************************************
 Ce fichier contient une interface qui s'appelle ControllerInterface. 
 
 Le but est d’obliger tous les contrôleurs (comme HomeController, ForumController, etc.) à avoir une méthode index().

 Ce fichier ne contient pas le code de la méthode, il dit juste : “toutes les classes qui m’utilisent  DOIVENT avoir une méthode index()
 ****************************************************/

interface ControllerInterface{

    // Elle oblige toutes les classes qui utilisent cette interface
    // à définir une méthode "index"
    public function index();
}