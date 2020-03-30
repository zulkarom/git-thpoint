

<div class="modal" id="calcModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">KINDLY PUT THE QUANTITY</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">


<?php 
			$size = 60;
			for($i=1;$i<=9;$i++){
				echo '<button class="btn btn-info btn-lg item-qty-express" value="'.$i.'" style="font-size:22px;height:'.$size.'px;width:'.$size.'px;margin:10px"><b> '.$i.'</b> </button> ';
			}
			
			
			?>


<hr />
			<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4"><input id="con-calc" class="form-control" />
</div>
</div>
			<?php 
			$size = 60;
			for($i=0;$i<=9;$i++){
				if($i==5){
					echo '
					<button type="button" id="calc-clear" class="btn btn-warning btn-md btn-rounded" style="width:90px;height:'.$size.'px">CLEAR</button>
					<br />';
				}
				echo '<button class="btn btn-success btn-lg item-quantity" value="'.$i.'" style="font-size:22px;height:'.$size.'px;width:'.$size.'px;margin:10px"><b> '.$i.'</b> </button> ';
			}
			
			
			?>
			
			<button type="button" id="calc-confirm" class="btn btn-danger btn-md btn-rounded" style="width:90px;height:<?=$size?>px">OK</button>
			
	
		

            </div>
            <div class="modal-footer">
			<span  style="margin: 0 auto">
	
			
               <button type="button" class="btn btn-warning btn-md btn-rounded" data-dismiss="modal" style="height:50px">ClOSE</button>
			   </span>
              
            </div>
        </div>
    </div>
</div>
