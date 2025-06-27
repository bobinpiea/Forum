<?php
    // Récupération du topic et de ses messages depuis les données envoyées par le contrôleur
    // $topic contient toutes les infos du sujet en cours
    // $messages contient tous les messages liés à ce topic (table message)
    $topic = $result["data"]["topic"];
    $messages = $result["data"]["messages"];
?>

<!-- Affichage du titre du sujet (topic) -->
<h1><?= $topic->getTitle() ?></h1>

<!-- Boucle pour parcourir tous les messages du topic -->
<!-- Pour chaque message, on crée une div avec les infos associées -->
<?php foreach ($messages as $message) { ?>
    <div>
        <!-- Affichage du contenu du message (texte écrit par l'utilisateur) -->
        <p><?= $message->getContent() ?></p>

        <!-- Affichage des informations sur l'auteur du message -->
        <p>
            Posté par 
            <?php if ($message->getUser()) : ?>
                <!-- Si le message a bien un utilisateur associé, on affiche son pseudo -->
                <?= $message->getUser()->getNickName() ?>
            <?php else : ?>
                <!-- Sinon on indique "Anonyme" (au cas où l'utilisateur n'existe plus ou est absent) -->
                <em>Anonyme</em>
            <?php endif; ?>

            <!-- Affichage de la date et l'heure de création du message A REVOIR ---------- -->
            le <?= date("d/m/Y", strtotime($message->getCreationDate())) ?>
            à <?= date("H:i", strtotime($message->getCreationDate())) ?>
        </p>

        <!-- LIEN POUR SUPPRIMER UN MESSAGE -->
        <p>
            <a href="index.php?ctrl=forum&action=deleteMessage&id=<?= $message->getId() ?>">Supprimer</a>
        </p>
    </div>
<?php } ?>

<!-- FORMULAIRE POUR AJOUTER UN NOUVEAU MESSAGE -->


<h3>Ajouter un message :</h3>


<form action="index.php?ctrl=forum&action=addMessageToTopic&id=<?= $topic->getId() ?>" method="post">

 
    <label for="content">Votre message :</label><br>
    <textarea id="content" name="content" rows="4" cols="50" required></textarea><br>

      <!-- Champ user_id----------- -->
    <!-- 
    <input type="hidden" name="user_id" value="1">
    -->

    <!-- Bouton pour envoyer le message -->
    <input type="submit" value="Envoyer">
</form>