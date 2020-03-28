<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'STAFF PAGE';

?>

<style>
    .modal-dialog {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;

    }

    .modal-content {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
        background-color: #FFFFFF !important;
    }
	
	.modal-header {
        border-bottom: 1px solid #ffffff !important;
    }

    .modal-footer {
        border-top: 1px solid #ffffff !important;
    }

</style>
<div class="container">


<?php $form = ActiveForm::begin() ?>
<br />

<?=$form->field($model, 'campaign_id')->dropDownList($model->campaignList())->label('CAMPAIGN')?>

<div class="row">
<div class="col-md-6">
<?=$form->field($model, 'product_id')->dropDownList([])->label('PRODUCT')?>
</div>
<div class="col-md-1">

<?php 
if(!$model->point_value){
	$model->point_value = 1;
}
echo $form->field($model, 'point_value')->textInput()->label('Qty')?>
</div>

<div class="col-md-5">
<?=$form->field($model, 'customer_phone')->textInput()->label('CUSTOMER ID')?>
</div>


</div>

<button id="modalActivate" type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalPreview">
    Graphic Interface
</button>

<?= Html::submitButton('Submit Point',['class' => 'btn btn-primary '])?>



	



<?php ActiveForm::end(); ?>

<br />

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
	  <th>#</th>
        <th>Campaign</th>
        <th>Customer</th>
		<th>Current Point</th>
        <th>Accumulated Points</th>
		<th>Time</th>
		<th></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	
	if($list){
		$i = 1;
		foreach($list as $row){
			echo '
			<tr>
	  <td>'.$i.'. </td>
		 <td>'.$row->campaign->campaign_name .'</td>
        <td>'.$row->customer->customer_name .'</td>
       
        <td>'.$row->point_value .'</td>
		 <td>'.$row->accumulatedPoints() .'</td>
		  <td>'.$row->point_at .'</td>
		  <td>';
		  echo Html::a('<i class="icon-trash"></i>',['']);
		  
		  echo '</td>
      </tr>
			
			';
		$i++;
		}
	}
	
	
	?>
      

    </tbody>
  </table>
</div>

<br /><br /><br /><br />

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">THE POINT</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <h1 class="section-heading text-center wow fadeIn my-5 pt-3"> Not for money, but for humanity</h1>
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-md btn-rounded">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<?php 

$this->registerJs('

$("#customerpoint-customer_phone").focus();

');

?>