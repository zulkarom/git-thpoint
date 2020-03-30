<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CustomerReward;

/**
 * CustomerRewardSearch represents the model behind the search form of `backend\models\CustomerReward`.
 */
class CustomerRewardSearch extends CustomerReward
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'campaign_id', 'product_reward_id', 'has_claimed', 'issue_claim_by'], 'integer'],
            [['reward_at', 'claimed_at'], 'safe'],
            [['point_value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CustomerReward::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'campaign_id' => $this->campaign_id,
            'reward_at' => $this->reward_at,
            'product_reward_id' => $this->product_reward_id,
            'has_claimed' => $this->has_claimed,
            'claimed_at' => $this->claimed_at,
            'issue_claim_by' => $this->issue_claim_by,
        ]);

        return $dataProvider;
    }
}
