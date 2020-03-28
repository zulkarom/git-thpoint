<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerRewardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-reward-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'reward_at') ?>

    <?= $form->field($model, 'reward_type') ?>

    <?php // echo $form->field($model, 'product_reward_id') ?>

    <?php // echo $form->field($model, 'cash_value') ?>

    <?php // echo $form->field($model, 'has_claimed') ?>

    <?php // echo $form->field($model, 'claimed_at') ?>

    <?php // echo $form->field($model, 'issue_claim_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
