<?php

use dosamigos\chartjs\ChartJs;
use backend\models\Stats;
use backend\models\Semester;


/* @var $this yii\web\View */

$this->title = 'Report Overview';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<?=$this->render('_period_select', ['model' => $form])?>
<section class="content">
      <!-- Info boxes -->
	  
	  <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-heart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL POINTS<br> TODAY</span>
              <span class="info-box-number"><?=$form->pointToday?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-heart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL POINTS<br> THE MONTH</span>
              <span class="info-box-number"><?=$form->pointMonth?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-gift"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CLAIMED REWARD<br>TODAY</span>
              <span class="info-box-number"><?=$form->claimedRewardToday?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-gift"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CLAIMED REWARD<br>THE MONTH</span>
              <span class="info-box-number"><?=$form->claimedRewardMonth?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>
	  
	  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>RM<?=$form->saleToday?></h3>

              <p>TOTAL SALE VALUE <br>TODAY</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>RM<?=$form->saleMonth?></h3>

              <p>SALE VALUE <br>THE MONTH</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>RM<?=$form->rewardToday?></h3>

              <p>REWARD SALE VALUE <br>TODAY</p>
            </div>
            <div class="icon">
              <i class="fa fa-gift"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <h3>RM<?=$form->rewardMonth?></h3>

              <p>REWARD SALE VALUE <br>CURRENT MONTH</p>
            </div>
            <div class="icon">
              <i class="fa fa-gift"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
      </div>
      








	  
	  
	  <div class="row">
<div class="col-md-12">


<div class="box box-primary">
<div class="box-header ">

<div class="box-title">

Current Month Sales (<?=$form->month . '/' . $form->year?>)
</div>
</div>
<div class="box-body"><?php 

$labels = array();
$data = array();
$getData = $form->getDailyData();
$labels = $getData[0];
$data = array_values($getData[1]);
//print_r($data);die();

echo ChartJs::widget([
    'type' => 'bar',
    'options' => [
       
        'width' => 400,
		'height' => 100
    ],
    'data' => [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => "Sales",
                'backgroundColor' => '#327fa8',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $data
            ],
        ]
    ]
]);
?></div>
</div>



</div>

<div class="col-md-4">





</div>

</div>


<div class="row">
<div class="col-md-12">


<div class="box box-success">
<div class="box-header ">

<div class="box-title">

Current Year Sales (<?=$form->year?>)
</div>
</div>
<div class="box-body"><?php 

$labels = array();
$data = array();
$getData = $form->getMonthlyData();
$labels = array_values($getData[0]);
$data = array_values($getData[1]);
//print_r($data);die();

echo ChartJs::widget([
    'type' => 'bar',
    'options' => [
       
        'width' => 400,
		'height' => 100
    ],
    'data' => [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => "Sales",
                'backgroundColor' => '#327fa8',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $data
            ],
        ]
    ]
]);
?></div>
</div>



</div>

<div class="col-md-4">





</div>

</div>



<div class="row">
<div class="col-md-6">


<div class="box box-info">
<div class="box-header ">

<div class="box-title">

Top Customers (<?=$form->year?>)
</div>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Phone</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 

$cust = $form->topCustomers;
if($cust){
	foreach($cust as $c){
		echo ' <tr>
        <td>'.$c->customer->customer_name.'</td>
        <td>RM '.$c->ringgit.'</td>
        <td>'.$c->customer->customer_phone.'</td>
      </tr>';
	}
	
}

?>

     
   
    </tbody>
  </table>
</div>



</div>
</div>
</div>

<div class="col-md-6">


<div class="box box-info">
<div class="box-header ">

<div class="box-title">

Top Products (<?=$form->year?>)
</div>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>

	<?php 

$cust = $form->topProducts;
if($cust){
	foreach($cust as $c){
		echo ' <tr>
        <td>'.$c->product->product_name.'</td>
        <td>RM '.$c->ringgit.'</td>
        <td>'.$c->product->product_price.'</td>
      </tr>';
	}
	
}

?>

    </tbody>
  </table>
</div>


</div>
</div>
</div>


</div>
      
      
	  

</section>



