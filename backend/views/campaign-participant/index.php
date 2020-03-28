<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CampaignParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign Participants: ' . $campaign->campaign_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-participant-index">


<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'customer.customer_name',
			'customer.customer_phone',
			'joint_at:datetime',
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{delete}',
                //'visible' => false,
                'buttons'=>[
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id, 'campaign' => $model->campaign_id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this participant?',
                                'method' => 'post',
                            ],
                        ]) ;
                    }
                ],
            
            ]

        ],
    ]); ?></div>
</div>

</div>
