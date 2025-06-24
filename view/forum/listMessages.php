<?php
    // On récupère les infos du topic et des messages dans les données passées par le contrôleur
    $topic = $result["data"]['topic']; 
    $messages = $result["data"]['messages']; 
?>

<h1>Messages par topic : <?= $topic->getTitle() ?></h1>

<?php

foreach($messages as $message ){ ?>
    <p>
         <a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $message->getUser()->getId() ?>">
        <?= $message->getContent() ?> 
        </a>
        par <?= $message->getUser()->getNickName() ?>
        le <?= $message->getCreationDate()?>
    </p>
<?php } ?>



