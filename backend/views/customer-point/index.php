<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerPointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-point-index">


   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'campaign.campaign_name',
            'customer.customer_name',
            'point_at',
            
            'point_value',
			'sale_value:currency',
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 3%'],
                'template' => '{delete}',
                //'visible' => false,
                'buttons'=>[
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this point?',
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
