<?php
$topic = $result["data"]["topic"];
$messages = $result["data"]["messages"];
?>

<h1><?= $topic->getTitle() ?></h1>

<?php foreach ($messages as $message) { ?>
    <div>
        <p><?= $message->getContent() ?></p>
        <p>
            Posté par <?= $message->getUser()->getNickName() ?>
            le <?= $message->getCreationDate() ?>
        </p>
    </div>
<?php } ?>


<p>
    <a href="index.php?ctrl=forum&action=addMessage&id=<?= $topic->getId() ?>">Ajouter un message</a>
</p>