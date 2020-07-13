<?php
use yii\widgets\ActiveForm;
use backend\models\Campaign;
use yii\helpers\ArrayHelper;
use common\models\Common;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'period-form',
'action' => $model->action,
'method' => 'get',

]); 


$cur_year = date('Y');
$last_year = $cur_year - 1;
$last2 = $cur_year - 2;
$last3 = $cur_year - 3;
$arr_year = [$cur_year=>$cur_year,$last_year => $last_year, $last2=>$last2, $last3=>$last3];
?>  
<div class="row">
	
<div class="col-md-6">
<?= $form->field($model, 'campaign')->dropDownList(
               ArrayHelper::map(Campaign::find()->where(['is_active' => 1])->all(),'id', 'campaign_name')
    )->label(false) ?>
</div>

<div class="col-md-2">
<?= $form->field($model, 'month')->dropDownList(
              Common::months()
    )->label(false) ?>
</div>
<div class="col-md-2">
<?= $form->field($model, 'year')->dropDownList(
              $arr_year
    )->label(false) ?>
</div>

</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#dashboardform-campaign").change(function(){
	$("#period-form").submit();
});

$("#dashboardform-year").change(function(){
	$("#period-form").submit();
});

$("#dashboardform-month").change(function(){
	$("#period-form").submit();
});

');

?>