Le dossier app (est comme une boite à outils)

- Il ne contient pas le contenu du site.
- Il contient les outils pour que le site fonctionne proprement comme : 
charger des classes
se connecter à la BDD 
faire des redirections
gérer les sessions, etc.



Autoloader.php : Il permet de charger automatiquement les classes qu’on appelle ailleurs.

AbstractController.php : Il contient des méthodes utiles pour tous les contrôleurs. C’est la “base”.

ControllerInterface.php : Il oblige tous les contrôleurs à avoir au moins une méthode index().

DAO.php : C’est le lien avec la base de données. Il fait les requêtes SQL.

Manager.php : Il contient des méthodes partagées pour tous les “managers” (classe de modèle).

Session.php : Il gère les utilisateurs connectés et les messages d’erreur ou succès.
