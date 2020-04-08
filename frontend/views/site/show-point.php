<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\barcode\BarcodeGenerator as BarcodeGenerator;

$this->title = 'Show Point';
$this->params['breadcrumbs'][] = $this->title;
?>
<br />
<div class="container">
<div class="row">
<div class="col-md-4" align="center">
<h5>Welcome, <?=$customer->customer_name?></h5>

<div id="showBarcode"></div>

<?php 
$optionsArray = array(
'elementId'=> 'showBarcode', /* div or canvas id*/
'value'=> $customer->customer_phone, /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'code128',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
'settings' => [
	'barWidth' => 3,
	'barHeight' => 80,

]
 
);
echo BarcodeGenerator::widget($optionsArray);

?>
</div>
<div class="col-md-8">

<div class="row">
<div class="col-md-5">
<div class="pricing-entry bg-light pb-4 mb-4 text-center">
<div>
<h4><i class="icon-gift"></i></h4>
	<h3 class="mb-3">My Reward</h3>
	
	<p><span class="price"><?=count($customer->unclaimedRewards)?></span> <br /><span class="per">Unclaimed</span>
	
	</p>
</div>

</div>
</div>

<?php 

$cam = $customer->uniqueCampaignPoint;

if($cam){
	foreach($cam as $c){
		?>
		
		<div class="col-md-5">
<div class="pricing-entry bg-light pb-4 mb-4 text-center">
<div>
<h4><i class="icon-heart"></i></h4>
	<h3 class="mb-3"><?=$c->campaign->campaign_name?></h3>
	<p><span class="price"><?=$c->campaign->pointsByCustomer($customer->id)?></span> <br /><span class="per">Accumulate Point(s)</span></p>
</div>

</div>
</div>
		<?php
	}
}

?>



</div>




<?php 


?>




</div>
</div>


<br />


</div>
