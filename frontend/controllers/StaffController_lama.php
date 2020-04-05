<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use backend\models\CustomerPoint;
use backend\models\CustomerReward;
use yii\db\Expression;
use backend\models\Customer;
use backend\models\CampaignParticipant;
use backend\models\Campaign;
use backend\models\Product;
use backend\models\CampaignPromotedProduct;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class StaffController extends Controller
{
	public $layout = 'website';
	public $reward = 0;
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
		$default = Campaign::find()->where(['is_default' => 1])->one();
		
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
			'list' => $list,
			'default' => $default
 		]);
    }
	
	public function actionLogin()
    {
        return $this->render('login', [

		]);
    }
	
	public function actionSubmitForm(){
		$error = [
			0 => 'Good',
			1 => 'No record for the customer',
			2 => 'Failed to Participate',
			3 => 'Not Promoted Product',
			4 => 'Failed to get the point',
			5 => 'Product not exist',
			6 => 'Zero quantity'
		];
		if(Yii::$app->request->post()){
			$campaign_id = Yii::$app->request->post('campaign');
			$customer_id = Yii::$app->request->post('customer');
			$quantity = Yii::$app->request->post('qty');
			$product_id = Yii::$app->request->post('product');
			
			$product = Product::findOne($product_id);
			if(!$product){
				return json_encode([5, $error[5]]);
			}
			
			
			$customer = Customer::findOne(['customer_phone' => $customer_id]);
			if($customer){
				$participant = CampaignParticipant::findOne(['campaign_id' => $campaign_id, 'customer_id' => $customer->id]);
				if(!$participant){
					$new = new CampaignParticipant;
					$new->campaign_id = $campaign_id;
					$new->customer_id = $customer->id;
					$new->joint_at = new Expression('NOW()');
					if(!$new->save()){
						return json_encode([2, $error[2]]);
					}
				}
				
				
				
				
				$point = CampaignPromotedProduct::find()->where(['campaign_id' => $campaign_id, 'product_id' => $product_id])->one();
				if(!$point){
					return json_encode([3, $error[3]]);
				}
				
				
				if($quantity > 0){
					//return $this->processPoint($campaign_id, $product_id, $product->product_price, $point->point_value, $customer->id, $quantity);
					$flag = $this->processPoint($campaign_id, $product_id, $product->product_price, $point->point_value, $customer->id, $quantity);
					
					
					if($flag == true){
						return json_encode([0, $customer->customer_name . ' has got the point.']);
					}else{
						return json_encode([4, $error[4]]);
					}
				}else{
					return json_encode([6, $error[6]]);
				}
				 
				 
			}else{
				return json_encode([1, $error[1]]);
			}
		}
		
	}
	
	private function processPoint($campaign, $product, $price, $point, $customer, $quantity){
		$curr_point = $point * $quantity;
		$put_point = $this->putPoint($campaign, $product, $price, $point, $customer, $quantity);
		if($put_point){
			//check reward
			
			$last_point = $put_point;
			$accumulated = CustomerPoint::find()
			->where(['campaign_id' => $campaign, 'customer_id' => $customer, 'reward_id' => 0])
			->sum('point_value * quantity');
			
			//=============cari berapa kena kumpul: 10.1 ======================
			$campaign_model = Campaign::findOne($campaign);
			$reward_at = $campaign_model->reward_point_at;
			//===========================================================
			
			if($accumulated >= $reward_at){ // klu dah cukup point atau lebih
				//put reward
				for($i=1;$accumulated >= $reward_at;$i++){
					
					$balance_point = $accumulated - $reward_at;
					$reward = new CustomerReward;
					$reward->campaign_id = $campaign;
					$reward->customer_id = $customer;
					$reward->reward_at = new Expression('NOW()');
					$reward->point_value = $reward_at;
					
					if($reward->save()){
						$this->reward = $this->reward + 1; // get number of reward
						//===============================================
						$prev_point = $accumulated - $curr_point; // cth: 9
						$reward_this_point = $reward_at - $prev_point; // cth: 1.1
						//============================================
						$this->updatePreviousPointReward($campaign, $customer, $reward->id, $reward_this_point, $last_point);
						//add new bal forward cth: 0.9
						$foward = $accumulated - $reward_at;
						if($foward){
							//may to consider burning it!!!!!!!!!!! if less than curr unit point
							//$last_point = $this->putPoint($campaign, $product, 0, $foward, $customer, 1);
							
						}
						
						$accumulated = CustomerPoint::find()
						->where(['campaign_id' => $campaign, 'customer_id' => $customer, 'reward_id' => 0])
						->sum('point_value * quantity');
						$curr_point = $foward;
						
					}
					$accumulated = $balance_point;
				}
				
			}
			return true;
		}else{
			return false;
		}
	}
	
	private function putPoint($campaign, $product, $price, $point, $customer, $quantity){
		$model = new CustomerPoint;
		$model->sale_value = $price;
		$model->point_value = $point;
		$model->campaign_id = $campaign;
		$model->product_id = $product;
		$model->customer_id = $customer;
		$model->quantity = $quantity;
		$model->point_at = new Expression('NOW()');
		$model->staff_id = Yii::$app->user->identity->id;
		if($model->save()){
			return $model->id;
		}else{
			return false;
		}
	}
	
	private function updatePreviousPointReward($campaign, $customer, $reward, $reward_this_point, $last_point){
		$prev = CustomerPoint::find()->where(['campaign_id' => $campaign, 'customer_id' => $customer, 'reward_id' => 0])->all();
		if($prev){
			foreach($prev as $p){
				if($p->id == $last_point){
					$p->reward_point_value = $reward_this_point;
					$p->reward_id = $reward;
					$p->save();
				}else{
					$pq = $p->point_value * $p->quantity;
					$p->reward_point_value = $pq;
					$p->reward_id = $reward;
					$p->save();
				}
			}
		}
	}
	
	public function actionCreateCustomer(){
		
		$model = new Customer;
		
		if(Yii::$app->request->post()){
			$name = Yii::$app->request->post('name');
			$phone = Yii::$app->request->post('phone');
			
			$model->customer_name = $name;
			$model->customer_phone = $phone;
			$model->created_at = new Expression('NOW()');
			$model->created_by = Yii::$app->user->identity->id;
			if($model->save()){
				return json_encode([0 ,  'good']);
			}else{
				return json_encode([1 ,  'Failed to create customer']);
			}
		}
		
		
	}
	
	
	public function actionSearchReward(){
		if(Yii::$app->request->post()){
			$phone = Yii::$app->request->post('phone');
			$customer = Customer::findOne(['customer_phone' => $phone]);
			if($customer){
				$reward = CustomerReward::find()
				->where(['customer_id' => $customer->id, 'has_claimed' => 0])
				->orderBy('id ASC')
				->all()
				;
				if($reward){
					$rwd = ArrayHelper::map($reward, 'id', 'campaign.campaign_name');
					$points = ArrayHelper::toArray($reward[0]->customerPoints);
					$campaign = $reward[0]->campaign;
					$first_campaign = $campaign->campaign_name;
					
					$list_reward = ArrayHelper::map($campaign->rewardProducts, 'product_id', 'productAndPrice');
					
					return json_encode([0, $customer->customer_name, $rwd, $list_reward, $points]);
				}else{
					return json_encode([2 ,  'No reward as yet for ' . $customer->customer_name]);
				}
			}else{
				return json_encode([1 ,  'Customer not found']);
			}
		}
	}
	
	
}
