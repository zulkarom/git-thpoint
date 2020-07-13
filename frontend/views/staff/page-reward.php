<style>
.mytable th, .mytable td {
	padding:2px;
}
</style>

<div id="page-reward" style="display:none">

<div class="row">
<div class="col-md-7">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>


 
	  <tr>
        <td align="right">
		<button id="modalPhoneReward" type="button" class="btn btn-warning">
    Customer ID
</button>
		</td>
        <td>
		
		<div class="input-group" style="width:80%">
  <input type="text" class="form-control" id="reward_customer_id" value="" style="border-color:#28a745">
  <div class="input-group-append">
  
  <button class="btn btn-outline-success" type="button" id="btn-search-reward">Search</button>
  
  </div>
</div>

<span id="search-result"></span>
		</td>
		
      </tr>

	  <tr id="row-campaign" style="display:none">
        <td align="right">		
		<button id="modalReward" type="button" class="btn btn-danger">
    Select Campaign
</button>
		
		</td>
        <td>
<input type="hidden" id="con-reward-selected-id" value="" />
<h5><b id="con-reward-selected"></b></h5>
		
		
		</td>
      </tr>
	  <tr id="row-product" style="display:none">
        <td align="right">
		<button id="modalProductReward" type="button" class="btn btn-info">
    Select Product
</button>
		
		</td>
        <td>
<input type="hidden" id="con-prod-reward-selected-id" value="" />
<h5><b id="con-prod-reward-selected"></b></h5>
		
		
		</td>
      </tr>
	  
	   <tr>
        <td align="right">
		
		</td>
        <td>
		<button id="btn-issue-reward" style="display:none" type="button" class="btn btn-success">
    <i class="icon-gift"></i> Issue Reward
</button>

		
		
		</td>
      </tr>
	  
	  
    </tbody>
  </table>
</div>

<div id="issue-result" align="center"></div>

</div>
<div class="col-md-5">

<div><strong>RECENT REWARD</strong>   <button type="button" id="refresh-rewards" class="btn btn-default btn-sm float-right"> Refresh</button></div>


<div class="table-responsive">
  <table class="table table-striped table-hover mytable2">
    <thead>
      <tr>
	  <th>Date</th>
        <th>Customer</th>
		<th>Products</th>
		
      </tr>
    </thead>
    <tbody id="tb-list-body-reward">
      
     
    </tbody>
  </table>
</div>


</div>

</div>






</div>
