<?php 

use richardfan\widget\JSRegister;
use yii\helpers\Url;

JSRegister::begin(); 
?>
<script>
$("#btn-search-reward").click(function(){
   search();
});

$("#reward_customer_id").on('keypress',function(e) {
    if(e.which == 13) {
         search();
    }
});

$("#modalReward").click(function(){
	$("#rewardModalPreview").modal("show");
});

$("#modalProductReward").click(function(){
	$("#rewardProductModalPreview").modal("show");
});

function search(){
	$("#search-result").html('Searching...');
	$.ajax({url: "<?=Url::to(['/staff/search-reward'])?>", 
	timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		phone: $("#reward_customer_id").val(),
	},
	success: function(result){
		//$("#search-result").html(result);
		console.log(result);
		var res = JSON.parse(result);
		if(res[0] == 0){
			var name = res[1];
			var kira = Object.keys(res[2]).length;
			var rewardTxt = kira == 1 ? 'reward' : 'rewards';
			$("#search-result").html("<h5><b>"+name+" has "+kira+" "+rewardTxt+"</b></h5>");
			//put rewards in modal
			const arr_rwd = Object.entries(res[2]);
			//console.log(arr_rwd);
			var str_rwd = '';
			for (const rwd of arr_rwd) {
				//alert(rwd);
			  str_rwd += '<span><button class="btn btn-danger btn-lg item-product" campaign="" value="" style="height:80px;margin:10px""> '+ rwd[1] +':'+rwd[0]+' </button></span>';
			}
			$("#con-modal-reward").html(str_rwd);
			//put product rewards in modal
			const arr_product = Object.entries(res[3]);
			//console.log(arr_rwd);
			var str_product = '';
			for (const prod of arr_product) {
				//alert(rwd);
			  str_product += '<span><button class="btn btn-info" campaign="" value="" style="height:50px;margin:5px""> '+ prod[1] + ' </button></span>';
			}
			
			
			$("#con-modal-reward-product").html(str_product);
			
	
			
		}else{
			$("#search-result").html('Sorry, ' + res[1]);
		}   
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $("#search-result").html('Error: ' + errorMessage);
    }
  
  
  });
}
</script>
<?php JSRegister::end(); ?>


