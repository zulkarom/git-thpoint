<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerReward */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-reward-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'campaign_id')->textInput() ?>

    <?= $form->field($model, 'reward_at')->textInput() ?>

    <?= $form->field($model, 'reward_type')->textInput() ?>

    <?= $form->field($model, 'product_reward_id')->textInput() ?>

    <?= $form->field($model, 'cash_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'has_claimed')->textInput() ?>

    <?= $form->field($model, 'claimed_at')->textInput() ?>

    <?= $form->field($model, 'issue_claim_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
