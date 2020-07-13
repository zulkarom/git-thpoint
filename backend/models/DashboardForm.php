<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class DashboardForm extends Model
{
    public $year;
    public $month;
	public $campaign;
	public $action;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month', 'campaign'], 'required'],
			[['year', 'month', 'campaign'], 'integer'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

}
