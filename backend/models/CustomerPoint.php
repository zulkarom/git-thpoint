<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer_point".
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $customer_id
 * @property string $point_at
 * @property string $sale_value
 *
 * @property Campaign $campaign
 * @property Customer $customer
 */
class CustomerPoint extends \yii\db\ActiveRecord
{
	public $customer_phone;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_point';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campaign_id', 'customer_id', 'point_at', 'point_value', 'quantity', 'staff_id', 'product_id', 'sale_value'], 'required'],
			
            [['campaign_id', 'customer_id', 'product_id', 'quantity', 'reward_id', 'staff_id'], 'integer'],
			
            [['point_at'], 'safe'],
			
            [['customer_phone', 'staff_id', 'point_value', 'sale_value', 'reward_point_value'], 'number'],
			
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign',
			'product_id' => 'Product',
            'customer_id' => 'Customer',
            'point_at' => 'Point At',
            'point_value' => 'Point Value',
        ];
    }
	
	public function campaignList(){
		$list = Campaign::find()->select('id, campaign_name')
		->where(['is_active' => 1])
		->all();
		return ArrayHelper::map($list, 'id', 'campaign_name');
	}
	
	public function accumulatedPoints(){
		return self::find()->where(['campaign_id' => $this->campaign_id, 'customer_id' => $this->customer_id])->sum('point_value');
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
