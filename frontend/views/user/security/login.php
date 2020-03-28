<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'STAFF LOGIN';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="container">
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">



<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>
				
				
			
               <?=$form->field($model, 'login')
						->label('STAFF ID',['class'=>'field-label text-muted mb10'])
            ->textInput(['placeholder' => 'STAFF ID'])
                    ;
                    ?>

                    <?= $form->field(
                        $model,
                        'password'           )
                        ->passwordInput(['placeholder' => 'PASSWORD'])
                         ->label('PASSWORD',['class'=>'field-label text-muted mb10'])
                           
                         ?>
         

                <?php /// $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
				
	
                                

                                <?= Html::submitButton(
                    Yii::t('user', 'LOG MASUK'),
                    ['class' => 'btn btn-primary ', 'tabindex' => '4']
                ) ?>
	
	
	
                

                <?php ActiveForm::end(); ?>
				<br />
       


</div>
</div>
</div>