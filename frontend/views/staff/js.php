<?php 

use richardfan\widget\JSRegister;
use yii\helpers\Url;

JSRegister::begin(); 
?>
<script>
$("#customer_id").on('keypress',function(e) {
    if(e.which == 13) {
        submitForm();
    }
});

$("#customer_id").focus();

$("#modalProduct").click(function(){
  showProductModal();
});
$("#modalQuantity").click(function(){
	$("#qty-focus").val(1);
  showQuantityModal();
});

$(".back-campaign").click(function(){
	var cam = $(this).attr('value');
	$("#productModalPreview-" + cam).modal("hide");
  $("#campaignModalPreview").modal("show");
});

$(".item-campaign").click(function(){
	var val = $(this).attr('value');
	var name = $(this).text();
	$("#con-campaign-name").text(name);
	$("#con-campaign-id").val(val);
	$("#campaignModalPreview").modal("hide");
	 showProductModal();
	$("#customer_id").focus();
});

$(".item-product").click(function(){
	var val = $(this).attr('value');
	var cam = $(this).attr('campaign');
	var name = $(this).text();
	$("#con-product-name").text(name);
	$("#con-product-id").val(val);
	$("#productModalPreview-" + cam).modal("hide");
	var qtyFocus = $("#qty-focus").val();
	if(qtyFocus == 1){
		showQuantityModal();
	}
	$("#customer_id").focus();
});

$(".item-qty-express").click(function(){
	var val = $(this).attr('value');
	$("#con-quantity").text(val);
	$("#con-quantity-id").val(val);
	closeQtyModal();
});

$("#calc-confirm").click(function(){
	var val = $("#con-calc").val();
	if(val == 0 || val == '0'){
		$("#con-quantity").text(1);
		$("#con-quantity-id").val(1);
	}else{
		val = parseInt(val);
		$("#con-quantity").text(val);
		$("#con-quantity-id").val(val);
	}
	closeQtyModal();
});

$("#phone-confirm").click(function(){
	var val = $("#con-phone").val();
	$("#customer_id").val(val);
	$("#reward_customer_id").val(val);
	$("#con-phone").val('');
	$("#phoneModalPreview").modal("hide");
});

$("#calc-clear").click(function(){
	$("#con-calc").val('');
	
});

$("#phone-clear").click(function(){
	$("#con-phone").val('');
	$("#con-phone").focus();
});

$("#phone-clear-one").click(function(){
	var phone = $("#con-phone").val();
	var result = phone.slice(0,-1);
	$("#con-phone").val(result);
	$("#con-phone").focus();
});

$(".item-quantity").click(function(){
	var curr = $("#con-calc").val();
	var val = $(this).attr('value');
	var now;
	if(curr){
		now = curr + val;
	}else{
		now = val;
	}
	
	
	$("#con-calc").val(now);
});

$(".item-phone").click(function(){
	var curr = $("#con-phone").val();
	var val = $(this).attr('value');
	var now;
	if(curr){
		now = curr + val;
	}else{
		now = val;
	}
	
	
	$("#con-phone").val(now);
});

$("#camToQty").click(function(){
	$("#qty-focus").val(1);
	$("#campaignModalPreview").modal("show");
});

$("#prodToQty").click(function(){
	$("#qty-focus").val(1);
	showProductModal();
});

$("#modalPhone").click(function(){
	showPhoneModal();
});

$("#modalPhoneReward").click(function(){
	$("#phoneModalPreview").modal("show");
	$("#con-phone").val($("#reward_customer_id").val());
	$("#con-phone").focus();
});

$("#btn-submit").click(function(){
	submitForm();
});

$("#btn-register").click(function(){
	var name = $("#con-register").val();
	if(name){
		register();
	}else{
		$("#result-register").text('Please fill in the name!');
	}
	
});

$("#slide-reward").click(function(){
	$("#page-point").hide();
	 $("#page-reward").show("slide", { direction: "right" }, 200);
	 $("#reward_customer_id").focus();
	 $("#result-submit").html('');
});
$("#slide-point").click(function(){
	$("#page-reward").hide();
	$("#page-point").show("slide", { direction: "left" }, 200);
	$('#issue-result').html('');
});

function showPhoneModal(){
	var cam = $("#con-campaign-id").val();
	var prod = $("#con-product-id").val();
	if(cam){
		if(prod){
			$("#phoneModalPreview").modal("show");
			$("#con-phone").val($("#customer_id").val());
			$("#con-phone").focus();
		}else{
			$("#productModalPreview-" + cam).modal("show");
		}
		
	}else{
		$("#campaignModalPreview").modal("show");
	}
}


function submitForm(){
	var customer = $("#customer_id").val();
	$("#reward_customer_id").val(customer);
	var prod = $("#con-product-id").val();
	if(customer && prod){
		ajaxSubmit();
	}else{
		showPhoneModal();
	}
	
	

}

function showProductModal(){
	var cam = $("#con-campaign-id").val();
	if(cam){
		
		$("#productModalPreview-" + cam).modal("show");
	}else{
		$("#campaignModalPreview").modal("show");
	}
}

function showQuantityModal(){
	var cam = $("#con-campaign-id").val();
	var prod = $("#con-product-id").val();
	if(cam){
		if(prod){
			$("#calcModal").modal("show");
		}else{
			$("#productModalPreview-" + cam).modal("show");
		}
		
	}else{
		$("#campaignModalPreview").modal("show");
	}
}

function closeQtyModal(){
	$("#con-calc").val('');
	$("#qty-focus").val(0);
	$("#calcModal").modal("hide");
	$("#customer_id").focus();
}

function openRegister(){
	$("#registerModal").modal("show");
	$("#con-register").focus();
}

function ajaxSubmit(){
	
	$("#result-submit").html('Processing...');
	
	$.ajax({url: "<?=Url::to(['/staff/submit-form'])?>", 
	timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		campaign: $("#con-campaign-id").val(),
		product: $("#con-product-id").val(),
		qty: $("#con-quantity-id").val(),
		customer: $("#customer_id").val()
	},
	success: function(result){
		//$("#result-submit").html(result);
		var res = JSON.parse(result);
		if(res){
			if(res[0] == 0){
				$("#result-submit").html('Yeah! ' + res[1]);
				$("#con-quantity").text(1);
				$("#con-quantity-id").val(1);
				$("#customer_id").val('');
				$("#customer_id").focus();
				$("#btn-undo").click(function(){
					var points = $(this).attr('points');
					var rewards = $(this).attr('rewards');
					undoPoints(points, rewards);
				});
			}else if(res[0] == 1){
				openRegister();
			}else{
				$("#result-submit").html('Sorry, ' + res[1]);
			}
		}else{
			$("#result-submit").html('Sorry, response is not good');
		}
		
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $('#result-submit').html('Error: ' + errorMessage);
    }
  
  
  });
}

function undoPoints(points, rewards){
	$('#result-submit').html('Processing...');
	$.ajax({url: "<?=Url::to(['/staff/undo-points'])?>", 
	timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		points: points,
		rewards: rewards,
	},
	success: function(result){

		if(result == 1){
			$('#result-submit').html('The action has been undone.');
		}
		
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
       $('#result-submit').html('Error: ' + errorMessage);
    }
  
  
  });
}

function register(){
	$.ajax({url: "<?=Url::to(['/staff/create-customer'])?>", 
	timeout: 5000,     // timeout milliseconds
	type: 'POST',  // http method
    data: { 
		name: $("#con-register").val(),
		phone: $("#customer_id").val(),
	},
	success: function(result){
		var res = JSON.parse(result);
		if(res[0] == 0){
			$("#registerModal").modal("hide");
			$("#con-register").val('');
			ajaxSubmit();
		}else{
			$("#result-register").html('Sorry, ' + res[1]);
		} 
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
        $('#result-register').append('Error: ' + errorMessage);
    }
  
  
  });
}






</script>
<?php JSRegister::end(); ?>


<?php JSRegister::begin(['position' => static::POS_BEGIN]); ?>
<script>
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}
</script>
<?php JSRegister::end(); ?>

