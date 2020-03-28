<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cam_prod_purchase".
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $product_id
 * @property string $created_at
 * @property int $point
 *
 * @property Campaign $campaign
 * @property Product $product
 */
class CampaignPromotedProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cam_prom_prod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'point_value'], 'required'],
			
			
            [['campaign_id', 'product_id'], 'integer'],
			
			[['point_value'], 'number'],
			
            [['updated_at'], 'safe'],
			
			
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
            'point' => 'Point',
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
