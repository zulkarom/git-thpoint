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
	public $curr_point = 0;
	public $arrPoint = array();
	public $arrReward = array();
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
					$flag = $this->processPoint($campaign_id, $product_id, $product->product_price, $point->point_value, $customer->id, $quantity);			
					
					if($flag == true){
						$rwd = CustomerReward::find()
						->where(['customer_id' => $customer->id, 'has_claimed' => 0])
						->count();
						$acc = CustomerPoint::find()
						->where(['campaign_id' => $campaign_id, 'customer_id' => $customer->id, 'reward_id' => 0])
						->sum('point_value * quantity');
						$acc = $acc ? $acc : 0;
						$cur_point = $this->curr_point;
						$point_text = $cur_point == 1 ? 'point' : 'points';
						
						$point_created = json_encode($this->arrPoint);
						$reward_created = json_encode($this->arrReward);
						
						$msg = $customer->customer_name . ' has got '.$cur_point.' '.$point_text.'.<br />
						Accumulated Points ('.$acc.') ; Rewards ('.$rwd.') <br />
						<button class="btn btn-default" value="" id="btn-undo" points="'.$point_created.'" rewards="'.$reward_created.'">Undo</button>';
						return json_encode([0, $msg]);
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
		// we need to loop thru the quantity
		//ok current quantity = 15
		//berapa nak kumpul?
		//=============cari berapa kena kumpul: 10.1 ======================
			$campaign_model = Campaign::findOne($campaign);
			$reward_at = $campaign_model->reward_point_at;
		//===========================================================
		//nak cari berapa lg balance untuk dapat next reward
		//jadi kena cari berapa dah dikumpul
		
		
		
		$accumulated = CustomerPoint::find()
			->where(['campaign_id' => $campaign, 'customer_id' => $customer, 'reward_id' => 0])
			->sum('point_value * quantity');
		//so berapa lagi tinggal?
		$bal_next_reward = $reward_at - $accumulated; //contoh: 1.1
		$start_count = 1;
		$point_not_rewarded = 0;
		$original_accumulated = $accumulated;
		for($i=1;$i<=$quantity;$i++){
			//klu tak cukup skip
			
			//reset the accumulated
			$accumulated = $accumulated + $point;
			
			if($accumulated >= $reward_at){
				//klu cukup create point
				$put_point = $this->putPoint($campaign, $product, $price, $point, $customer, $start_count);
				//dan juga create reward
				//kena cari reward point this point
				//===============================================
				$reward_this_point = $reward_at - $original_accumulated; // cth: 10.1 - 9 = 1.1
				//============================================
				$this->createReward($campaign, $customer, $reward_at, $put_point, $reward_this_point);
				//reset the count & accumulated
				$start_count = 0;
				$accumulated = 0;
				$original_accumulated = 0;
				$point_not_rewarded = 0;
				//ok apa jadi kepada kes baki : cth 2
			}else{
				$point_not_rewarded++;
			}
		$start_count++;
		}
		
		if($point_not_rewarded > 0){
			$put_point = $this->putPoint($campaign, $product, $price, $point, $customer, $point_not_rewarded);
		}
		
		
		if($put_point){
			return true;
		}else{
			return false;
		}
	}
	
	private function createReward($campaign, $customer, $reward_at, $last_point, $reward_this_point){
		$reward = new CustomerReward;
		$reward->campaign_id = $campaign;
		$reward->customer_id = $customer;
		$reward->reward_at = new Expression('NOW()');
		$reward->point_value = $reward_at;
		
		if($reward->save()){
			$this->arrReward[] = $reward->id;
			$this->updatePreviousPointReward($campaign, $customer, $reward->id, $reward_this_point, $last_point);
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
	
	
	
	private function putPoint($campaign, $product, $price, $point, $customer, $quantity){
		$model = new CustomerPoint;
		$model->sale_value = $price;
		$model->point_value = $point;
		$this->curr_point = $this->curr_point + ($point * $quantity);
		$model->campaign_id = $campaign;
		$model->product_id = $product;
		$model->customer_id = $customer;
		$model->quantity = $quantity;
		$model->point_at = new Expression('NOW()');
		$model->staff_id = Yii::$app->user->identity->id;
		if($model->save()){
			$this->arrPoint[] = $model->id;
			return $model->id;
		}else{
			return false;
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
				//send sms
				$msg = urlencode("RM0.00 Welcome to our point system. Collect 10 points and you'll get 1 free coffee. We are looking forward to meet you again. Thanks. Regards SKYHINT");
				
				$xml = file_get_contents("http://www.bulksms2u.com/websmsapi/ISendSMS.aspx?username=zulkarom&password=1q2w3e&message=".$msg."&mobile=6".$phone."&Sender=zulkarom&type=1");
				
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
				->all();
				if($reward){
					$list_reward = ArrayHelper::map($reward, 'id', 'campaign.campaign_name');
					
					list($points, $products) = $this->pointsAndProducts($reward[0]);
					
					return json_encode([0, $customer->customer_name, $list_reward, $products, $points]);
					
				}else{
					return json_encode([2 ,  'no reward as yet for ' . $customer->customer_name]);
				}
			}else{
				return json_encode([1 ,  'customer not found']);
			}
		}
	}
	
	public function actionProductReward(){
		if(Yii::$app->request->post()){
			$id = Yii::$app->request->post('reward');
			//so apa kita nak sekrang list point
			//dgn list product
			$reward = CustomerReward::findOne($id);
			list($points, $products) = $this->pointsAndProducts($reward);
			return json_encode([$products, $points]);
		} 
	}
	
	public function actionIssueReward(){
		if(Yii::$app->request->post()){
			$reward = Yii::$app->request->post('reward');
			$product = Yii::$app->request->post('product');
			$model = CustomerReward::findOne($reward);
			$customer = $model->customer->customer_name;
			$model->product_reward_id = $product;
			$model->has_claimed = 1;
			$model->claimed_at = new Expression('NOW()');
			$model->issue_claim_by = Yii::$app->user->identity->id;
			$price = Product::findOne($product)->product_price;
			$model->reward_sale_value = $price;
			if($model->save()){
				$reward = CustomerReward::find()
				->where(['customer_id' => $model->customer_id, 'has_claimed' => 0])
				->count();
				$msg = 'The reward has been successfully issued to '. $customer . '. <br />
				Balance reward ('.$reward.')<br />
				<button class="btn btn-default" value="'.$model->id .'" id="btn-undo-reward">Undo</button>';
				return json_encode([0, $msg]);
			}else{
				return json_encode([1, 'Failed to issue reward']);
			}
		}
	}
	
	public function actionUndoPoints(){
		if(Yii::$app->request->post()){
			$rewards = json_decode(Yii::$app->request->post('rewards'));
			$points = json_decode(Yii::$app->request->post('points'));
			if($rewards){
				CustomerReward::deleteAll(['id' => $rewards]);
				CustomerPoint::updateAll(['reward_id' => 0], ['reward_id' => $rewards]);
			}
			if($points){
				CustomerPoint::deleteAll(['id' => $points]);
			}
			return 1;
		}
	}
	
	public function actionRecentPoints(){
		$list = CustomerPoint::find()->orderBy('point_at DESC')->limit(5)->all();
		$html = '';
		if($list){
			foreach($list as $row){
				$val = $row->point_value * $row->quantity;
			$html .= '<tr>
			<td>'. date('d M Y', strtotime($row->point_at)) .'</td>
			<td>'.$row->customer->customer_name .'</td>
			<td>'.$row->product->product_name .'</td>
			<td>'. $val .'</td>
			<td>'.$row->reward_id .'</td>
		  </tr>';
			}
		}
			return $html;
	}
	
	public function actionRecentRewards(){
		$list = CustomerReward::find()->orderBy('reward_at DESC')->limit(5)->all();
		$html = '';
		if($list){
			foreach($list as $row){
			$html .= '<tr>
			<td>'. date('d M Y', strtotime($row->reward_at)) .'</td>
			<td>'.$row->customer->customer_name .'</td>
			<td>'.$row->product->product_name .'</td>
		  </tr>';
			}
		}
			return $html;
	}
	
	public function actionUndoReward(){
		if(Yii::$app->request->post()){
			$reward = json_decode(Yii::$app->request->post('reward'));
			$model = CustomerReward::findOne($reward);
			$model->has_claimed = 0;
			$model->issue_claim_by = 0;
			$model->reward_sale_value = 0;
			$model->product_reward_id = 0;
			if($model->save()){
				return 1;
			}
			
		}
	}
	
	private function pointsAndProducts($reward){
		$points = ArrayHelper::toArray($reward->customerPointDetails);
		//return $avg_sale;
		$avg_sale = $points[1][0];
		$campaign = $reward->campaign;
		$list_product = ArrayHelper::map($campaign->rewardProductsAverage($avg_sale), 'product_id', 'productAndPrice');
		return [$points, $list_product];
	}
	
	
}
