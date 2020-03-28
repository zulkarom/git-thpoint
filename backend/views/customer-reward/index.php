<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerRewardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Rewards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-reward-index">


    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'customer.customer_name',
            'campaign.campaign_name',
            'reward_at',
            'reward_type',
            //'product_reward_id',
            //'cash_value',
            //'has_claimed',
            //'claimed_at',
            //'issue_claim_by',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
</div>

</div>
