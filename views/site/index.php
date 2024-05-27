<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $events app\models\Event[] */

$this->title = 'Events';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($events as $event): ?>
        <div class="event">
            <h2><?= Html::encode($event->title) ?></h2>
            <p><?= Html::encode($event->description) ?></p>
            <p>Date: <?= Html::encode($event->date) ?></p>
            <h3>Organizers:</h3>
            <ul>
                <?php foreach ($event->organizers as $organizer): ?>
                    <li><?= Html::encode($organizer->name) ?> (<?= Html::encode($organizer->email) ?>)</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>