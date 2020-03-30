
<?php 
			
if($campaign){
foreach($campaign as $cam){
?>

<div class="modal" id="productModalPreview-<?=$cam->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">KINDLY SELECT A PRODUCT</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			
	
				
				<?php
				$products = $cam->promotedProducts;
				if($products){
					foreach($products as $product){
						echo '<span><button class="btn btn-info btn-lg item-product" campaign="'.$cam->id .'" value="'.$product->product_id .'" style="height:80px;margin:10px""> '.$product->product->product_name .' <br /><i>(RM'.$product->product->product_price.')</i></button></span>';
					}
				}
				
				?>
					
				
			


            </div>
            <div class="modal-footer">
			<span style="margin: 0 auto">
			<button type="button" value="<?=$cam->id?>" class="btn btn-danger btn-md btn-rounded back-campaign" style="height:50px"><i class="icon-arrow-left"></i> BACK TO CAMPAIGN</button>  
                <button type="button" class="btn btn-warning btn-md btn-rounded" data-dismiss="modal" style="height:50px">ClOSE</button>
			</span>
			
              
            </div>
        </div>
    </div>
</div>

<?php
}
}

?>
