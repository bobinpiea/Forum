Ce dossier contient les “contrôleurs”.

Leur rôle : ce sont eux qui prennent les décisions quand un utilisateur fait une action

Par exemple : s'il tape

index.php?ctrl=forum&action=listTopicsByCategory, 

le ForumController va être appelé, il va chercher les bons sujets et envoyer la bonne vue à afficher.

C’est un peu comme le chef d’orchestre : il reçoit une demande → il décide quoi faire → il appelle un manager → il envoie la réponse.


il a deux roles: 

il décide quoi faire quand quelqu’un clique
Si quelqu’un clique sur “Liste des catégories”, il doit appeler le manager des catégories

il prépare les données à envoyer à la vue
Il récupère les catégories et les envoie à la page vue qui va les afficher


En somme: 

Metaphore: 
le site est un restaurant.
	•	L’utilisateur est un client
	•	Le contrôleur est le serveur
	•	Les managers sont les cuisiniers (ils vont chercher les plats dans la base de données).
	•	Les vues sont les assiettes qu’on apporte au client.



Rappel : 

Opérateurs de classe et d'objet
:: - Appelle une méthode statique dans une classe
Exemple : Session::getUser()
-> - Appelle une méthode sur un objet déjà créé
Exemple : $user->getEmail()
new - Crée une nouvelle instance d'une classe
Exemple : $user = new User()
self:: - Référence à la classe courante (méthodes statiques)
Exemple : self::$count
parent:: - Référence à la classe parent
Exemple : parent::__construct()
$this-> - Référence à l'instance courante de l'objet
Exemple : $this->name


