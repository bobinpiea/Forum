Le rôle des class managers est d’interagir avec la base de données

Les Entities représentent les données (un User, un Topic)
Les Managers vont chercher ces données dans la base (grace aux requetes sql, comme dans cinema)

	UserManager.php -> pour faire des requêtes SQL sur les utilisateurs
	TopicManager.php -> pour gérer les sujets
	CategoryManager.php -> pour gérer les catégories


 il peut : ( a revenir dessus )
	- findAll() -> récupérer tous les éléments d’une table
	- findOneById($id) → récupérer un élément précis par son id
	- add() -> insérer une nouvelle ligne
	- delete() -> supprimer


    En somme 
On ne fait jamais de requêtes SQL brutes dans le contrôleur !
Le contrôleur demande au Manager -> Le Manager va voir la base.