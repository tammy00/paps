<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PeriodoInscricaoMonitoria;

/**
 * PeriodoInscricaoMonitoriaSearch represents the model behind the search form about `app\models\PeriodoInscricaoMonitoria`.
 */
class PeriodoInscricaoMonitoriaSearch extends PeriodoInscricaoMonitoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['dataInicio', 'dataFim', 'periodo', 'ano', 'justificativa'], 'safe'],
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
        $query = PeriodoInscricaoMonitoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
        ]);

        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        return $dataProvider;
    }
}
