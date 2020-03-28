<?php 
use yii\helpers\Html;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/webasset');

$btn_kursus = Html::a('Lihat Senarai Kursus', ['site/course'], ['class' => 'btn btn-secondary px-4 py-3 mt-3']);

?>
<section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/3cups.png);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">Where the battle rages, there the loyalty of the soldier is proved</h1>
          
          </div>
        </div>
        </div>
      </div>

      <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/hphone.png);">
      	<div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">The strength of a family, like the strength of an army, is in its loyalty to each other<span></span></h1>
           
          </div>
        </div>
        </div>
      </div>
	  <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/management.png);">
      	<div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">Hold faithfulness and sincerity as first principles<span></span></h1>
        
          </div>
        </div>
        </div>
      </div>
    </section>
	
	
	<section class="ftco-section testimony-section bg-light">
	<div class="container">
        <div class="row justify-content-center mb-5 pb-2">
          <div class="col-md-8 text-center heading-section ftco-animate fadeInUp ftco-animated">
            <h2 class="mb-4"><span>Your Credential</span> Here</h2>
            <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
          </div>
        </div>
        
		
		
		
      </div>
	  
	  </section>