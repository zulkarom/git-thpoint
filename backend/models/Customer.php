<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $created_at
 * @property int $created_by
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_name', 'customer_phone', 'created_at', 'created_by'], 'required'],
            [['created_at'], 'safe'],
            [['created_by', 'customer_phone'], 'integer'],
            [['customer_name'], 'string', 'max' => 100],
			[['customer_phone'], 'unique'], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'customer_phone' => 'Customer Phone',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
	
	public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
	
	public function getUnclaimedRewards()
    {
        return $this->hasMany(CustomerReward::className(), ['customer_id' => 'id'])->where(['has_claimed' => 0]);
    }
	
	public function getUniqueCampaignPoint(){
		return CustomerPoint::find()
		->select('distinct(campaign_id)')
		->where(['customer_id' => $this->id, 'reward_id' => 0])
		->all();
	}


}
