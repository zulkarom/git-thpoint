<?php

use dosamigos\chartjs\ChartJs;
use backend\models\Stats;
use backend\models\Semester;


/* @var $this yii\web\View */

$this->title = 'Current Year Overview';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');


if($campaigns){
	foreach($campaigns as $campaign){
		?>
		<h4><?=$campaign->campaign_name?></h4>
<section class="content">
      <!-- Info boxes -->
      
      
	  
	  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>RM<?=$campaign->saleToday?></h3>

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
              <h3>RM<?=$campaign->saleMonth?></h3>

              <p>SALE VALUE <br>CURRENT MONTH</p>
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
              <h3>RM<?=$campaign->rewardToday?></h3>

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
             <h3>RM<?=$campaign->rewardMonth?></h3>

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
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-heart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL POINTS<br> TODAY</span>
              <span class="info-box-number"><?=$campaign->pointToday?></span>
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
              <span class="info-box-text">TOTAL POINTS<br> CURRENT MONTH</span>
              <span class="info-box-number"><?=$campaign->pointMonth?></span>
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
              <span class="info-box-number"><?=$campaign->claimedRewardToday?></span>
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
              <span class="info-box-text">CLAIMED REWARD<br>CURRENT MONTH</span>
              <span class="info-box-number"><?=$campaign->claimedRewardMonth?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>





</section>
		<?php
	}
}
?>


