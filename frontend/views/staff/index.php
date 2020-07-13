<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\JuiAsset;

$this->title = 'STAFF PAGE';

$campaign_id = '';
$campaign_name = '';
if($default){
	$campaign_id = $default->id;
	$campaign_name = $default->campaign_name;
}

?>

<style>
.mytable2 th, .mytable2 td {
	padding: 4px;
	font-size: 14px;
}
</style>

<div class="container">

<div id="page-point">

<div class="row">
<div class="col-md-7">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td width="35%" align="right">
		<!-- <button id="camToQty" type="button" class="btn btn-danger">
    C2Q
</button>  -->
		<button id="modalCampaign" type="button" class="btn btn-danger" data-toggle="modal" data-target="#campaignModalPreview">
    Select Campaign
</button>
</td>

        <td>
		<input type="hidden" id="con-campaign-id" value="<?=$campaign_id?>" />
		<h5><b id="con-campaign-name"><?=$campaign_name?></b></h5>
		
		
		</td>

      </tr>
      <tr>
        <td align="right">
		<!-- <button id="prodToQty" type="button" class="btn btn-info">
    P2Q
</button>  -->
		<button id="modalProduct" type="button" class="btn btn-info">
    Select Product
</button></td>
        <td>
		<input type="hidden" id="con-product-id" value="" />
		<h5><b id="con-product-name"></b></h5>
		
		</td>
      </tr>
      <tr>
        <td align="right">


<button id="modalQuantity" type="button" class="btn btn-success">
    Quantity
</button>
<input type="hidden" id="qty-focus" value="0" />
		</td>
        <td>
		<input type="hidden" id="con-quantity-id" value="1" />
		<h5><b id="con-quantity">1</b></h5>
		
		</td>
      </tr>
	  <tr>
        <td align="right">
		<button id="modalPhone" type="button" class="btn btn-warning">
    Customer ID
</button>
		</td>
        <td>
<input class="form-control" id="customer_id" onkeypress="return isNumberKey(event)" style="width:70%" />
		
		
		</td>
      </tr>
	  <tr>
        <td align="right">
		
		</td>
        <td>
		<button id="btn-submit" type="button" class="btn btn-success">
    <i class="icon-save"></i> Submit Point
</button>

		
		
		</td>
      </tr>
    </tbody>
  </table>
</div>

<div id="result-submit" align="center"></div>


</div>

<div class="col-md-5">
<div><strong>RECENT POINTS</strong>   <button type="button" id="refresh-points" class="btn btn-default btn-sm float-right"> Refresh</button></div>


<div class="table-responsive">
  <table class="table table-striped table-hover mytable2">
    <thead>
      <tr>
	  <th>Date</th>
        <th>Customer</th>
		<th>Products</th>
        <th>Points</th>
        <th>Reward</th>
      </tr>
    </thead>
    <tbody id="tb-list-body">
      
     
    </tbody>
  </table>
</div>


</div>

</div>











</div>

<?=$this->render('page-reward')?>








<br />



<br /><br /><br /><br />

</div>

<?php 


echo $this->render('modal-campaign', [
'campaign' => $campaign
]);

echo $this->render('modal-product', [
'campaign' => $campaign
]);

echo $this->render('modal-quantity');
echo $this->render('modal-customer');
echo $this->render('modal-register');

echo $this->render('modal-reward');
echo $this->render('modal-reward-product');

$this->render('js');
$this->render('jsReward');
JuiAsset::register($this);
?>