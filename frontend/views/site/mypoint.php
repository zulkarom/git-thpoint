<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Point';
$this->params['breadcrumbs'][] = $this->title;
?>
<br />
<div class="container">
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">




<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput() ?>
<div class="form-group">
        
<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>


<br />


</div>
