<?php
    // On récupère le topic courant (objet Topic)
    $topic = $result["data"]['topic'];

    // On récupère tous les messages associés à ce topic (tableau d’objets Message)
    $messages = $result["data"]['messages'];
?>

<!-- TITRE PRINCIPAL : on affiche le titre du topic -->
<h1>Messages du topic : "<?= $topic ?>"</h1>

<!-- LIEN POUR RETOURNER À LA LISTE DES TOPICS DE LA CATÉGORIE -->
<p>
    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategoryId() ?>">
        ← Retour à la liste des topics de la catégorie
    </a>
</p>

<!-- AFFICHAGE DE LA LISTE DES MESSAGES -->
<?php 
// S’il y a des messages
if ($messages):
    // Pour chaque message, on affiche son contenu
    foreach($messages as $message): 
?>

    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        
        <!-- CONTENU DU MESSAGE -->
        <p><?= $message->getContent() ?></p>

        <!-- INFOS SUPPLÉMENTAIRES : auteur et date -->
        <?php
            $date = new DateTime($message->getCreationDate());
            $dateFormatted = $date->format("d/m/Y à H\hi");
        ?>
        <p><small>
            Écrit par utilisateur #<?= $message->getUserId() ?> le <?= $dateFormatted ?>
        </small></p>

        <!-- BOUTON POUR SUPPRIMER CE MESSAGE -->
        <p>
            <a 
                href="index.php?ctrl=forum&action=deleteMessage&id=<?= $message->getId() ?>" 
                onclick="return confirm('Confirmer la suppression de ce message ?')"
            >
                🗑️ Supprimer ce message
            </a>
        </p>
    </div>

<?php 
    endforeach;

else: 
    // Si aucun message n’est encore publié
?>
    <p>Aucun message pour ce topic pour le moment.</p>
<?php 
endif;
?>

<!-- FORMULAIRE POUR AJOUTER UN NOUVEAU MESSAGE -->
<h2>Ajouter un message</h2>

<form action="index.php?ctrl=forum&action=addMessageToTopic&id=<?= $topic->getId() ?>" method="post">

    <p>
        <label for="content">Message :</label><br>
        <textarea name="content" id="content" cols="60" rows="5" required></textarea>
    </p>

    <p>
        <label for="user_id">Auteur (ID utilisateur) :</label><br>
        <input type="number" name="user_id" id="user_id" value="1" required>
        <!-- Simulation d’un utilisateur connecté -->
    </p>

    <p>
        <input type="submit" value="Envoyer le message">
    </p>
</form>