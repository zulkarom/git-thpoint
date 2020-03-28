<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $product_name
 * @property string $product_price
 * @property string $created_at
 *
 * @property Campaign[] $campaigns
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'product_price', 'created_at'], 'required'],
            [['product_price'], 'number'],
            [['created_at'], 'safe'],
            [['product_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'product_price' => 'Product Price',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['product_id' => 'id']);
    }
	
	public function getProductAndPrice(){
		return $this->product_name . ' (RM' . $this->product_price . ')';
	}
}
