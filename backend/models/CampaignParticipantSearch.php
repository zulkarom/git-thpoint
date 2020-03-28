<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CampaignParticipant;

/**
 * CampaignParticipantSearch represents the model behind the search form of `backend\models\CampaignParticipant`.
 */
class CampaignParticipantSearch extends CampaignParticipant
{
	public $campaign;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'customer_id'], 'integer'],
            [['joint_at'], 'safe'],
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
        $query = CampaignParticipant::find()->where(['campaign_id' => $this->campaign]);

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
            'joint_at' => $this->joint_at,
        ]);

        return $dataProvider;
    }
}
