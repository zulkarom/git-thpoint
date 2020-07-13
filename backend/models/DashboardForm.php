<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\CustomerPoint;
use common\models\Common;
use yii\helpers\ArrayHelper;

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
	
	public function getDailyData(){
		$monthData = CustomerPoint::find()
		->select('DAY(point_at) as hari, point_at, sum(sale_value) as ringgit')
		->where(['MONTH(point_at)' => $this->month, 'YEAR(point_at)' => $this->year, 'campaign_id' => $this->campaign])
		->groupBy('hari')
		->all();
		
		$d=cal_days_in_month(CAL_GREGORIAN, $this->month , $this->year);
		$arr = array();
		$days = array();
		for($i=1;$i<=$d;$i++){
			$arr[$i.'.'] = 0;
			$days[] = $i;
		}
		$arr2 = array();
		if($monthData){
			foreach($monthData as $data){
				$day = date('j', strtotime($data->point_at));
				$arr2[$day. '.'] = $data->ringgit;
			}
		}
		
		return array($days, array_merge($arr, $arr2));
		
	}
	
	public function getMonthlyData(){
		$monthData = CustomerPoint::find()
		->select('MONTH(point_at) as bulan, point_at, sum(sale_value) as ringgit')
		->where(['YEAR(point_at)' => $this->year, 'campaign_id' => $this->campaign])
		->groupBy('bulan')
		->all();
		
		$m = Common::months_short();
		
		$arr = array();
		for($i=1;$i<=12;$i++){
			$arr[$i.'.'] = 0;
		}
		$arr2 = array();
		if($monthData){
			foreach($monthData as $data){
				$month = date('n', strtotime($data->point_at));
				$arr2[$month. '.'] = $data->ringgit;
			}
		}
		
		return array($m, array_merge($arr, $arr2));
		
	}
	
	public function getSaleMonth(){
		$result = CustomerPoint::find()
		->where([
			'campaign_id' => $this->campaign, 
			])
		->andWhere(['MONTH(point_at)' => $this->month, 'YEAR(point_at)' => $this->year])
		->sum('sale_value * quantity');
		return $result ? $result : 0;
	}
	
	public function getPointMonth(){
		$result = CustomerPoint::find()
		->where([
			'campaign_id' => $this->campaign, 
			])
		->andWhere(['MONTH(point_at)' => $this->month, 'YEAR(point_at)' => $this->year])
		->sum('point_value * quantity');
		return $result ? $result : 0;
	}
	
	public function getPointToday(){
		$result = CustomerPoint::find()
		->where([
			'campaign_id' => $this->campaign, 
			])
		->andWhere('point_at >= CURDATE()')
		->sum('point_value * quantity');
		return $result ? $result : 0;
	}
	
	public function getClaimedRewardMonth(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->campaign, 
			'has_claimed' => 1,
			])
		->andWhere(['MONTH(reward_at)' => $this->month, 'YEAR(reward_at)' => $this->year])
		->count();
	}
	
	public function getClaimedRewardToday(){
		return CustomerReward::find()
		->where([
			'campaign_id' => $this->campaign, 
			'has_claimed' => 1,
			])
		->andWhere('reward_at >= CURDATE()')
		->count();
	}
	
	public function getRewardToday(){
		$result =  CustomerReward::find()
		->where([
			'campaign_id' => $this->campaign, 
			'has_claimed' => 1,
			])
		->andWhere('reward_at >= CURDATE()')
		->sum('reward_sale_value');
		return $result ? $result : 0;
	}
	
	public function getRewardMonth(){
		$result = CustomerReward::find()
		->where([
			'campaign_id' => $this->campaign, 
			'has_claimed' => 1,
			])
		->andWhere(['MONTH(reward_at)' => $this->month, 'YEAR(reward_at)' => $this->year])
		->sum('reward_sale_value');
		return $result ? $result : 0;
	}
	
	public function getTopCustomers(){
		$list = CustomerPoint::find()
		->select('customer_id , sum(sale_value * quantity) as ringgit')
		->where(['YEAR(point_at)' => $this->year, 'campaign_id' => $this->campaign])
		->groupBy('customer_id')
		->orderBy('ringgit DESC')
		->limit(5)
		->all();
		
		return $list;
		
	}
	
	public function getTopProducts(){
		$list = CustomerPoint::find()
		->select('product_id , sum(sale_value * quantity) as ringgit')
		->where(['YEAR(point_at)' => $this->year, 'campaign_id' => $this->campaign])
		->groupBy('product_id')
		->orderBy('ringgit DESC')
		->limit(5)
		->all();
		
		return $list;
		
	}
	
	public function getSaleToday(){
		$result = CustomerPoint::find()
		->where([
			'campaign_id' => $this->campaign, 
			])
		->andWhere('point_at >= CURDATE()')
		->sum('sale_value * quantity');
		return $result ? $result : 0;
	}

}
