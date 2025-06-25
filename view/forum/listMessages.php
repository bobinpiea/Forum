<?php
    // On récupère les infos du topic et des messages dans les données passées par le contrôleur
    $topic = $result["data"]['topic']; 
    $messages = $result["data"]['messages']; 
?>

// Si le topic existe on va l'afficher sinon ca ne serait pas le cas
<?php if($topic): ?>

    <h1>Messages pour le topic : <?= $topic->getTitle() ?></h1>

    <?php
    // Pour chaque message du tableau $messages, on affiche les infos
    foreach($messages as $message ){ ?>
        <p>
            <!-- Ce lien pourrait pointer vers le profil du user par exemple -->
            <a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $topic->getId() ?>">
                <?= $message->getContent() ?> 
            </a>
            par <?= $message->getUser()->getNickName() ?>
            le <?= $message->getCreationDate()?>
        </p>
    <?php } ?>

<?php else: ?>

    <p style="color: red;">
        Le topic demandé n'existe pas ou a été supprimé.
    </p>

<?php endif; ?>


