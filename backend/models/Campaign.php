<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property int $id
 * @property int $product_id
 * @property int $reward_type
 * @property int $product_reward_id
 * @property int $cash_value
 * @property int $reward_point_at
 * @property string $reward_cash_at
 * @property string $campaign_name
 *
 * @property Product $product
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reward_type',  'campaign_name'], 'required'],
			
            [['reward_type', 'is_active', 'is_default'], 'integer'],
			
            [['cash_value', 'reward_point_at'], 'number'],
			
			[['updated_at'], 'safe'],
			
            [['campaign_name'], 'string', 'max' => 200],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           
            'reward_type' => 'Reward Type',
            'cash_value' => 'Cash Value Reward',
            'reward_point_at' => 'Point to Reward',
            'reward_cash_at' => 'Sales Value to Reward',
            'campaign_name' => 'Campaign Name',
			'rewardTypeStr'  => 'Reward Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotedProducts()
    {
        return $this->hasMany(CampaignPromotedProduct::className(), ['campaign_id' => 'id'])->orderBy('product_order ASC');
    }
	
	public function getRewardProducts()
    {
        return $this->hasMany(CampaignRewardProduct::className(), ['campaign_id' => 'id'])->orderBy('product_order ASC');
    }
	
	public function rewardProductsAverage($avg)
    {
		return CampaignRewardProduct::find()
		->joinWith(['product'])
		->where(['cam_prod_reward.campaign_id' => $this->id])
		->andWhere(['<=', 'product.product_price', $avg])
		->orderBy('cam_prod_reward.product_order ASC')
		->all();
    }
	
	public function typeList(){
		return [
		1 => 'Product Point with Product' , 
		//2 => 'Sales Value with Product' , 
		//3 => 'Quantity Product with Cash Value',
		//4 => 'Sales Value with Cash Value'
		
		];
	}
	
	public function getRewardTypeStr(){
		$arr = $this->typeList();
		return $arr[$this->reward_type];
	}
	
	public function pointsByCustomer($customer){
		return CustomerPoint::find()->where(['campaign_id' => $this->id, 'customer_id' => $customer, 'reward_id' => 0])->sum('point_value * quantity');
	}
	
	public function getSaleToday(){
		return CustomerPoint::find()
		->where([
			'campaign_id' => $this->id, 
			'reward_id' => 0,
			])
		->andWhere('point_at >= CURDATE()')
		->sum('sale_value * quantity');
	}
	
	public function getSaleMonth(){
		return CustomerPoint::find()
		->where([
			'campaign_id' => $this->id, 
			'reward_id' => 0,
			])
		->andWhere('MONTH(point_at) = MONTH(CURRENT_DATE())')
		->sum('sale_value * quantity');
	}
	
	public function getPointToday(){
		return CustomerPoint::find()
		->where([
			'campaign_id' => $this->id, 
			'reward_id' => 0,
			])
		->andWhere('point_at >= CURDATE()')
		->sum('point_value * quantity');
	}
	
	public function getPointMonth(){
		return CustomerPoint::find()
		->where([
			'campaign_id' => $this->id, 
			'reward_id' => 0,
			])
		->andWhere('MONTH(point_at) = MONTH(CURRENT_DATE())')
		->sum('point_value * quantity');
	}
	
	
	
	public function getRewardToday(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->id, 
			'has_claimed' => 1,
			])
		->andWhere('reward_at >= CURDATE()')
		->sum('reward_sale_value');
	}
	
	public function getRewardMonth(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->id, 
			'has_claimed' => 1,
			])
		->andWhere('MONTH(reward_at) = MONTH(CURRENT_DATE())')
		->sum('reward_sale_value');
	}
	
	public function getClaimedRewardToday(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->id, 
			'has_claimed' => 1,
			])
		->andWhere('reward_at >= CURDATE()')
		->count();
	}
	
	public function getClaimedRewardMonth(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->id, 
			'has_claimed' => 1,
			])
		->andWhere('MONTH(reward_at) = MONTH(CURRENT_DATE())')
		->count();
	}
}
