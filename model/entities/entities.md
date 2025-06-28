Chaque fichier ici représente une table de la base de données (comme user pour les utilisateurs, topic pour les sujets, etc.)

Mais sous forme de classe qu’on a appellé une entité.

	•	User.php = la classe User représente la table user dans la base
	•	Topic.php = la classe Topic représente la table topic


une classe Entity :
	•	contient des attributs (comme id, nickName, etc.)
	•	contient des getters et setters (pour accéder ou modifier les données)
	•	contient parfois des méthodes comme __toString() pour afficher proprement l’objet


Quand on récupère un utilisateur depuis la base de données, on ne reçoit pas une ligne  en SQL,
on reçoit un objet User avec toutes ses données

