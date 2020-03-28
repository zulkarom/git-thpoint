<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="campaign-view">


    <p>
		<?= Html::a('Campaign List', ['index'], ['class' => 'btn btn-info']) ?>
		 
        <?= Html::a('Update Campaign', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		
		<?= Html::a('Promoted Product', ['update-promote-product', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
		
		<?= Html::a('Reward Product', ['update-reward-product', 'id' => $model->id], ['class' => 'btn btn-success']) ?> 
		
		<?= Html::a('<span class="fa fa-user"></span> Participant', ['campaign-participant/index', 'campaign' => $model->id], ['class' => 'btn btn-primary']) ?>
		
		
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to completely delete this campaign?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

 <div class="box">
<div class="box-header"></div>
<div class="box-body">   <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'campaign_name',
            'rewardTypeStr',
			'reward_point_at',
			[
				'attribute' => 'is_active',
				'value' => function($model){
					return $model->is_active == 1 ? 'Yes' : 'No';
				}
				
			],
        ],
    ]) ?></div>
</div>


</div>
