

<div class="modal" id="rewardProductModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class=" modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">PRODUCT REWARD</h5>
                <button  type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center" >

			<div class="row">
<div class="col-md-5">
<b>Details of point earned</b>
<div class="table-responsive">
  <table class="table table-striped table-hover mytable" style="font-size:12px;">
    <thead>
      <tr>
	  <th>Date</th>
        <th>Product</th>
		<th>Qty</th>
		<th>Point</th>
		
        
		<th>Sales</th>
      </tr>
    </thead>
    <tbody id="con-table-points">
      
      
    </tbody>
	<tfoot>
	<tr><td colspan="2" align="right"><b>Total</b></td><td id="con-total-qty"></td><td id="con-total-point"></td><td>RM<span id="con-total-sale"></span></td></tr>
	<tr><td colspan="4" align="right"><b>Average</b></td><td>RM<span id="con-avg-sale"></span></td></tr>
	</tfoot>
  </table>
</div>

</div>

<div class="col-md-7" >
<b>KINDLY SELECT THE PRODUCT REWARD BELOW.</b>
<div id="con-modal-reward-product">

</div>
</div>

</div>
	
		

            </div>
            <div class="modal-footer">
			<span  style="margin: 0 auto">
	
	<button type="button" class="btn btn-danger btn-md btn-rounded" id="btn-reward-back" style="height:50px">BACK TO CAMPAIGN REWARD</button>
			
               <button type="button" class="btn btn-warning btn-md btn-rounded" data-dismiss="modal" style="height:50px">ClOSE</button>
			   </span>
              
            </div>
        </div>
    </div>
</div>
