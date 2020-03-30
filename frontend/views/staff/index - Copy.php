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

<div class="container">

<div id="page-point">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td width="35%" align="right">
		<button id="camToQty" type="button" class="btn btn-danger">
    C2Q
</button> 
		<button id="modalCampaign" type="button" class="btn btn-danger" data-toggle="modal" data-target="#campaignModalPreview">
    Select Campaign
</button>
</td>

        <td>
		<input type="hidden" id="con-campaign-id" value="<?=$campaign_id?>" />
		<h4><b id="con-campaign-name"><?=$campaign_name?></b></h4>
		
		
		</td>

      </tr>
      <tr>
        <td align="right">
		<button id="prodToQty" type="button" class="btn btn-info">
    P2Q
</button> 
		<button id="modalProduct" type="button" class="btn btn-info">
    Select Product
</button></td>
        <td>
		<input type="hidden" id="con-product-id" value="" />
		<h4><b id="con-product-name"></b></h4>
		
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
		<h4><b id="con-quantity">1</b></h4>
		
		</td>
      </tr>
	  <tr>
        <td align="right">
		<button id="modalPhone" type="button" class="btn btn-warning">
    Customer ID
</button>
		</td>
        <td>
		

		
		<div class="input-group mb-3" style="width:80%">
  <input type="text" class="form-control"  id="customer_id" onkeypress="return isNumberKey(event)">
  <div class="input-group-append">
  
  <button class="btn btn-outline-success" id="btn-submit" type="button"><i class="icon-save"></i> &nbsp;Submit Point</button>
  

  </div>
</div>
		
		
		</td>
      </tr>
	  <tr>
        <td align="right">
		
		</td>
        <td>

		</td>
      </tr>
    </tbody>
  </table>
</div>

<div id="result-submit" align="center"></div>


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

echo $this->render('modal-quantity', [
'campaign' => $campaign
]);

echo $this->render('modal-customer', [
'campaign' => $campaign
]);

echo $this->render('modal-register', [
'campaign' => $campaign
]);

$this->render('js');
JuiAsset::register($this);
?>