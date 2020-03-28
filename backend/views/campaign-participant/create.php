<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CampaignParticipant */

$this->title = 'Create Campaign Participant';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-participant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
