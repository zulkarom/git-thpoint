<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;

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

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td width="35%" align="right">
		
		<button id="modalCampaign" type="button" class="btn btn-danger" data-toggle="modal" data-target="#campaignModalPreview">
    Select Campaign
</button>
</td>
        <td>
		<input type="hidden" id="con-campaign-id" value="" />
		<h4><b id="con-campaign-name">COSTA COFFE AND LATTES</b></h4>
		
		
		</td>

      </tr>
      <tr>
        <td align="right"><button id="modalProduct" type="button" class="btn btn-info">
    Select Product
</button></td>
        <td>
		<h4><b>ICED MOCHA</b></h4>
		
		</td>
      </tr>
      <tr>
        <td align="right">
		<button id="modalActivate" type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalPreview">
    Quantity
</button>
		</td>
        <td>
		<h4><b>1</b></h4>
		
		</td>
      </tr>
	  <tr>
        <td align="right">
		<button id="modalActivate" type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalPreview">
    Customer ID
</button>
		</td>
        <td>

		<input class="form-control" id="customer_id" />
		
		</td>
      </tr>
    </tbody>
  </table>
</div>







<br />



<br /><br /><br /><br />

</div>

<!-- Modal -->
<div class="modal" id="campaignModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">PLEASE SELECT THE CAMPAIGN</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
			
			<?php 
			
			if($campaign){
				foreach($campaign as $cam){
					echo '
					<div class="form-group"><button class="btn btn-danger btn-lg item-campaign" value="'.$cam->id .'" style="height:90px;">'.$cam->campaign_name .'</button></div>
					';
				}
			}
			
			?>
			
			
			
			
			
            </div>
            <div class="modal-footer" align="center">
                <button type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal" style="margin: 0 auto">Close</button>
              
            </div>
        </div>
    </div>
</div>

<div class="modal" id="productModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">PLEASE SELECT THE PRODUCT</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">

            </div>
            <div class="modal-footer" align="center">
                <button type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal" style="margin: 0 auto">Close</button>
              
            </div>
        </div>
    </div>
</div>


<!-- Modal -->


<?php JSRegister::begin(); ?>
<script>
$("#customer_id").focus();

$("#modalProduct").click(function(){
  $("#productModalPreview").modal("show");
	//.find("#modalContent")
	//.load($(this).attr("value"));
});

$(".item-campaign").click(function(){
	$("#campaignModalPreview").modal("hide");
	var val = $(this).attr('value');
	var name = $(this).text();
	$("#con-campaign-name").text(name);
	$("#con-campaign-id").val(val);
});


</script>
<?php JSRegister::end(); ?>
