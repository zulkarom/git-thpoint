<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */

$this->title = 'Update Campaign: ' . $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="campaign-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
