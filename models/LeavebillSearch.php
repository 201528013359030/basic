<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leavebill;

/**
 * LeavebillSerach represents the model behind the search form about `app\models\Leavebill`.
 */
class LeavebillSearch extends Leavebill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'leaveType', 'leaveStartTime', 'leaveEndTime', 'reason', 'remark', 'applyTime', 'username', 'dep', 'spuser', 'tzuser', 'tongzhi', 'token', 'approvalPerson'], 'safe'],
            [['state'], 'integer'],
            [['days'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Leavebill::find();

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
            'leaveStartTime' => $this->leaveStartTime,
            'leaveEndTime' => $this->leaveEndTime,
            'applyTime' => $this->applyTime,
            'state' => $this->state,
            'days' => $this->days,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'userid', $this->userid])
            ->andFilterWhere(['like', 'leaveType', $this->leaveType])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'dep', $this->dep])
            ->andFilterWhere(['like', 'spuser', $this->spuser])
            ->andFilterWhere(['like', 'tzuser', $this->tzuser])
            ->andFilterWhere(['like', 'tongzhi', $this->tongzhi])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'approvalPerson', $this->approvalPerson]);

        return $dataProvider;
    }
}
