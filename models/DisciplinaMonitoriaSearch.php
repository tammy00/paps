<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DisciplinaMonitoria;

/**
 * MonitoriaSearch represents the model behind the search form about `app\models\DisciplinaMonitoria`.
 */
class DisciplinaMonitoriaSearch extends DisciplinaMonitoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nomeDisciplina', 'nomeCurso', 'nomeProfessor', 'codTurma'], 'safe'],
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
        $query = DisciplinaMonitoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'numPeriodo' => $this->numPeriodo,
            'anoPeriodo' => $this->anoPeriodo,
        ]);

        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'nomeCurso', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'nomeProfessor', $this->nomeProfessor]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);

        return $dataProvider;
    }
}
