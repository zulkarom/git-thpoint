<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-index">

    <p>
        <?= Html::a('Create Campaign', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			'campaign_name',
            'rewardTypeStr',
			[
				'attribute' => 'is_active',
				'value' => function($model){
					return $model->is_active == 1 ? 'Yes' : 'No';
				}
				
			],
            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[

					'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span> VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
            
                ],
            
            ]

        ],
    ]); ?></div>
</div>

</div>
