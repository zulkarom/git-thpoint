<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "customer_reward".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $campaign_id
 * @property string $reward_at
 * @property int $product_reward_id
 * @property string $point_value
 * @property int $has_claimed
 * @property string $claimed_at
 * @property int $issue_claim_by
 *
 * @property Campaign $campaign
 * @property Customer $customer
 * @property User $issueClaimBy
 */
class CustomerReward extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_reward';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'campaign_id', 'reward_at', 'point_value'], 'required'],
			
			
            [['customer_id', 'campaign_id', 'product_reward_id', 'has_claimed', 'issue_claim_by'], 'integer'],
			
            [['reward_at', 'claimed_at'], 'safe'],
			
            [['point_value'], 'number'],
			
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
            'customer_id' => 'Customer ID',
            'campaign_id' => 'Campaign ID',
            'reward_at' => 'Reward At',
            'reward_type' => 'Reward Type',
            'product_reward_id' => 'Product Reward ID',
            'point_value' => 'Point Value',
            'has_claimed' => 'Has Claimed',
            'claimed_at' => 'Claimed At',
            'issue_claim_by' => 'Issue Claim By',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueClaimBy()
    {
        return $this->hasOne(User::className(), ['id' => 'issue_claim_by']);
    }
}
