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

<div class="modal" id="campaignModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">KINDLY SELECT A CAMPAIGN</h5>
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
            <div class="modal-footer">
			
			
               <button type="button" class="btn btn-warning btn-md btn-rounded" data-dismiss="modal" style="height:50px; margin: 0 auto">ClOSE</button>
              
            </div>
        </div>
    </div>
</div>
