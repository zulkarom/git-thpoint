<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Signup form
 */
class PointForm extends Model
{
    public $phone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			['phone', 'required'],
			
            ['phone', 'trim'],
			
			['phone', 'number'],
           
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'phone' => 'PHONE',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

    }
}
