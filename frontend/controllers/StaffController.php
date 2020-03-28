<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use backend\models\CustomerPoint;
use yii\db\Expression;
use backend\models\Customer;
use backend\models\CampaignParticipant;
use backend\models\Campaign;

/**
 * Site controller
 */
class StaffController extends Controller
{
	public $layout = 'website';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }



    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new CustomerPoint;
		
		$campaign = Campaign::find()->where(['is_active' => 1])->all();
		
		$list = CustomerPoint::find()->where(['staff_id' => Yii::$app->user->identity->id])->limit(10)->orderBy('point_at DESC')->all();
		
		if ($model->load(Yii::$app->request->post())) {
			$customer = Customer::findOne(['customer_phone' => $model->customer_phone]);
			if($customer){
				$participant = CampaignParticipant::findOne(['campaign_id' => $model->campaign_id, 'customer_id' => $customer->id]);
				if(!$participant){
					$new = new CampaignParticipant;
					$new->campaign_id = $model->campaign_id;
					$new->customer_id = $customer->id;
					$new->joint_at = new Expression('NOW()');
					if(!$new->save()){
						$new->flashError();
					}
				}
				$model->customer_id = $customer->id;
				$model->point_at = new Expression('NOW()');
				$model->sale_value = $model->campaign->product->product_price;
				$model->staff_id = Yii::$app->user->identity->id;
				if($model->save()){
					Yii::$app->session->addFlash('success', $model->customer->customer_name . ' has got the point.');
					return $this->redirect(['index']);
				}
			}else{
				Yii::$app->session->addFlash('error', "Customer not exist");
			}
			
		}
		
        return $this->render('index', [
			'model' => $model,
			'campaign' => $campaign,
			'list' => $list
		]);
    }
	
	public function actionLogin()
    {
        return $this->render('login', [

		]);
    }
	
	/**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
	
	
}
