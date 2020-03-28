<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\MyAlert as Alert;

/* @var $this \yii\web\View */
/* @var $content string */
frontend\assets\WebAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/webasset');
?>
<?php $this->beginPage() ?>
    
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
  <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
		
    <title>THE POINT SYSTEM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
	
	<?php $this->head() ?>
	

   
  </head>
   
  <body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco_navbar ftco-navbar-light" id="ftco-navbar">
	    <div class="container d-flex align-items-center">
		<a href="<?=Url::to(['/site/index'])?>"><span id="logo"><img src="<?=$directoryAsset?>/images/logo.png" /> </span></a>
	    	<a class="navbar-brand" href="index.html"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			  </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
			
			<?php 
			if (Yii::$app->user->isGuest) {
				?>
				<li class="nav-item"><a href="<?=Url::to(['/site/index'])?>" class="nav-link pl-0">Home</a></li>
	        	<li class="nav-item"><a href="<?=Url::to(['/site/course'])?>" class="nav-link">My Point</a></li>
				
				<li class="nav-item"><a href="<?=Url::to(['/staff/index'])?>" class="nav-link">Staff</a></li>
				
				<li class="nav-item"><a href="#hubungi" class="nav-link">Contact Us</a></li>
				<?php
			}else{
				?>
				
				<li class="nav-item"><a href="<?=Url::to(['/staff/index'])?>" class="nav-link"><i class="icon-user"></i> <?=Yii::$app->user->identity->fullname?></a></li>
				
				<li class="nav-item"><a href="<?=Url::to(['/staff/index'])?>" class="nav-link"><i class="icon-check"></i> Key In</a></li>
				
				<li class="nav-item"><a href="<?=Url::to(['/staff/new-participant'])?>" class="nav-link"><i class="icon-plus"></i> New Participant</a></li>
				
				<li class="nav-item"><a href="<?=Url::to(['/site/logout'])?>" class="nav-link">Log Out</a></li>
				
				<?php
			}
				?>
	        	
				
				

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END navx -->
	

   
	 <?=Alert::show() ?>
	
    <?=$content?>

    
		
		
		
		

		
		


		
    <footer id="hubungi" class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2">Contact us</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Your Address Here. KL Lumpur Malaysia</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">603 500 500</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">email@email.my</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
      
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Links</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>My Point</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Staff</a></li>
            
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Contact us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">

            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2 mb-0">Connect With Us</h2>
            	<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made By <a href="https://skyhint.com" target="_blank">Skyhint Design</a> | Template by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

    <?php $this->endBody() ?>
  </body>
</html>

<?php $this->endPage() ?>