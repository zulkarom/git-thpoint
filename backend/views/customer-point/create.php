<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerPoint */

$this->title = 'Create Customer Point';
$this->params['breadcrumbs'][] = ['label' => 'Customer Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
