<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Product;

/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>
  <?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="campaign-form">

  

	
	<div class="row">
<div class="col-md-8">
<?= $form->field($model, 'campaign_name')->textInput() ?>
<?= $form->field($model, 'reward_type')->dropDownList( $model->typeList() ) ?>
<?= $form->field($model, 'reward_point_at')->textInput() ?>
<?= $form->field($model, 'is_active')->dropDownList([1=>'Yes', 0 => 'No'] ) ?>
	</div>
</div>
	


   

</div></div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Save Campaign', ['class' => 'btn btn-success']) ?>
    </div>
 <?php ActiveForm::end(); ?>