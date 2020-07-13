<?php 

use richardfan\widget\JSRegister;
use yii\helpers\Url;

JSRegister::begin(); 
?>
<script>

showRecentReward();

$("#btn-search-reward").click(function(){
   initSearch();
});

$("#reward_customer_id").on('keypress',function(e) {
    if(e.which == 13) {
         initSearch();
    }
});

$("#modalReward").click(function(){
	$("#rewardModalPreview").modal("show");
});

$("#modalProductReward").click(function(){
	$("#rewardProductModalPreview").modal("show");
});

$(".item-product-reward").click(function(){
	var val = $(this).attr('value');
	alert(val);
});

$("#btn-reward-back").click(function(){
	$("#rewardModalPreview").modal("show");
	$("#rewardProductModalPreview").modal("hide");
});

$("#btn-issue-reward").click(function(){
	
	var product = $("#con-prod-reward-selected-id").val();
	var reward = $("#con-reward-selected-id").val();
	if(product && reward){
		issueReward();
	}else if(reward){
		$("#rewardProductModalPreview").modal("show");
	}else{
		initSearch();
	}
	//validate customer product
	//validate campaign
	//validate customer id
});

function showRecentReward(){
	$('#tb-list-body-reward').html('Loading...');
	$.ajax({url: "<?=Url::to(['/staff/recent-rewards'])?>", 
	//timeout: 5000,     // timeout milliseconds
	type: 'GET',  // http method
	success: function(result){
		//console.log(result);
		$('#tb-list-body-reward').html(result);
		
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
       $('#tb-list-body-reward').html('Error: ' + errorMessage);
    }
  
  
  });
	
}

$("#refresh-rewards").click(function(){
	showRecentReward();
});

function issueReward(){
	$("#search-result").html('Loading...');
	$.ajax({
	url: "<?=Url::to(['/staff/issue-reward'])?>", 
	//timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		reward: $("#con-reward-selected-id").val(),
		product: $("#con-prod-reward-selected-id").val()
	},
	success: function(result){
		//$("#search-result").html(result);
		console.log(result);
		var res = JSON.parse(result);
		if(res){
			if(res[0] == 0){
				$("#issue-result").html('<i class="icon-check"></i> ' +  res[1]);
				$("#search-result").html('');
				emptyEverything();
				$("#btn-undo-reward").click(function(){
					var reward = $(this).attr('value');
					undoReward(reward);
				});
				showRecentReward();
			}else{
				$("#issue-result").html(res[1]);
			}
		}
		 
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $("#issue-result").html('Error: ' + errorMessage);
    }
  
  
  });
}

function initSearch(){
	//check ade bare ker
	var cus = $("#reward_customer_id").val();
	if(!cus || cus == ''){
		//open customer modal
		$("#phoneModalPreview").modal("show");
		$("#search-result").html('');
		emptyEverything();
		return false;
	}else{
		search();
	}
	
}

function showRewardButton(boo){
	if(boo){
		$("#row-campaign").show();
		$("#row-product").show();
		$("#btn-issue-reward").show();
	}else{
		$("#row-campaign").hide();
		$("#row-product").hide();
		$("#btn-issue-reward").hide();
	}
	
}

function search(){
	$("#search-result").html('Searching...');
	$('#issue-result').html('');
	$.ajax({url: "<?=Url::to(['/staff/search-reward'])?>", 
	//timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		phone: $("#reward_customer_id").val(),
	},
	success: function(result){
		//$("#search-result").html(result);
		//console.log(result);
		
		var res = JSON.parse(result);
		if(res[0] == 0){
			showRewardButton(true);
			var name = res[1];
			var kira = Object.keys(res[2]).length;
			var rewardTxt = kira == 1 ? 'reward' : 'rewards';
			$("#search-result").html("<h5><b>"+name+" has "+kira+" "+rewardTxt+"</b></h5>");
			//put rewards in modal
			const arr_rwd = Object.entries(res[2]);
			//console.log(arr_rwd);
			var str_rwd = '';
			var ir = 1;
			for (const rwd of arr_rwd) {
				//alert(rwd);
			  str_rwd += '<span><button class="btn btn-danger btn-lg item-reward" value="'+rwd[0]+'" style="height:80px;margin:10px""> '+ rwd[1] +':'+rwd[0]+' </button></span>';
			  if(ir == 1){
				  $("#con-reward-selected-id").val(rwd[0]);
				  $("#con-reward-selected").text(rwd[1] +':'+rwd[0]);
			  }
			  ir++;
			}
			$("#con-modal-reward").html(str_rwd);
			
			//===========
			putPointsProductReward(res[3], res[4]);
			//===========
			$(".item-reward").click(function(){
				emptyProductContainer(true);
				var val = $(this).attr('value');
				switchReward(val);
				var text = $(this).text();
				$("#con-reward-selected-id").val(val);
				$("#con-reward-selected").text(text);
				
				//empty
				$("#rewardModalPreview").modal("hide");
				$("#rewardProductModalPreview").modal("show");
				
				
			});
	
			
		}else{
			showRewardButton(false);
			$("#search-result").html('Sorry, ' + res[1]);
			emptyEverything();
		}   
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $("#search-result").html('Error: ' + errorMessage);
    }
  
  
  });
}

function emptyEverything(){
	
	$("#con-reward-selected-id").val('');
	$("#con-reward-selected").text('');
	emptyProductContainer(false);
	showRewardButton(false);
}

function emptyProductContainer(loading){
	var loadTxt = '';
	if(loading){
		loadTxt = 'Loading...';
	}
	
	$("#con-table-points").html('<tr><td colspan="5">'+loadTxt+'</td></tr>');
	$("#con-avg-sale").html('');
	$("#con-total-point").html('');
	$("#con-total-qty").html('');
	$("#con-total-sale").html('');
	$("#con-modal-reward-product").html(loadTxt);
	$("#con-prod-reward-selected-id").val('');
	  $("#con-prod-reward-selected").text('');
}

function switchReward(reward){
	$.ajax({
	url: "<?=Url::to(['/staff/product-reward'])?>", 
	//timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		reward: reward,
	},
	success: function(result){
		//$("#search-result").html(result);
		//console.log(result);
		var res = JSON.parse(result);
		putPointsProductReward(res[0], res[1]);
		 
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $("#search-result").html('Error: ' + errorMessage);
    }
  
  
  });
}

function putPointsProductReward(products, points){
	//put product rewards in modal
	const arr_product = Object.entries(products);
	//console.log(arr_rwd);
	var str_product = '';
	var ip = 1;
	for (const prod of arr_product) {
		//alert(rwd);
	  str_product += '<span><button class="btn btn-info item-product-reward"  value="'+ prod[0] + '" style="height:50px;margin:5px"> '+ prod[1] + ' </button></span>';
	  if(ip == 1){
		  $("#con-prod-reward-selected-id").val(prod[0]);
		  $("#con-prod-reward-selected").text(prod[1]);
	  }
	  ip++;
	}
	
	
	$("#con-modal-reward-product").html(str_product);
	
	//product points pulak
	var about_point = points;
	const list_point  = about_point[0];
	//console.log(arr_rwd);
	var str_points = '';
	var pvalue; var tpoint;
	for (const point of list_point) {
		//alert(rwd);
		pvalue = point[3];
		
	  str_points += '<tr><td>'+point[2]+'</td><td> '+point[0]+' (RM'+point[1]+')</td><td>'+point[4]+'</td><td>'+pvalue+'</td><td>RM'+point[5]+'</td></tr>';
	}
	
	$("#con-table-points").html(str_points);
	
	var res_total = about_point[1];
	var avg_sale = res_total[0];
	$("#con-avg-sale").html(avg_sale);
	$("#con-total-point").html(res_total[1]);
	$("#con-total-qty").html(res_total[2]);
	$("#con-total-sale").html(res_total[3]);
	
	//refresh jquery
	$(".item-product-reward").click(function(){
		var val = $(this).attr('value');
		var text = $(this).text();
		$("#con-prod-reward-selected-id").val(val);
		$("#con-prod-reward-selected").text(text);
		$("#rewardProductModalPreview").modal("hide");
	});
}

function undoReward(reward){
	$("#issue-result").html('Processing...');
	$.ajax({url: "<?=Url::to(['/staff/undo-reward'])?>", 
	//timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		reward: reward,
	},
	success: function(result){

		if(result == 1){
			$('#issue-result').html('The action has been undone.');
		}
		
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
      $("#issue-result").html('Error: ' + errorMessage);
    }
  
  
  });
}

</script>
<?php JSRegister::end(); ?>


