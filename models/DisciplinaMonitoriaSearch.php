<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DisciplinaMonitoria;

/**
 * DisciplinaMonitoriaSearch represents the model behind the search form about `app\models\DisciplinaMonitoria`.
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
            [['codDisciplina', 'nomeDisciplina', 'nomeCurso', 'nomeProfessor', 'codTurma'], 'safe'],
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

        $query->andFilterWhere(['like', 'codDisciplina', $this->codDisciplina]);
        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'nomeCurso', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'nomeProfessor', $this->nomeProfessor]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);

        return $dataProvider;
    }

    public function searchByPeriodo($ano, $semestre)
    {
        $query = DisciplinaMonitoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /*
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        } */

        $query->andFilterWhere([
            'numPeriodo' => $semestre,
            'anoPeriodo' => $ano,
        ]); /*

        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'nomeCurso', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'nomeProfessor', $this->nomeProfessor]);
        $query->andFilterWhere(['like', 'qtdVagas', $this->qtdVagas]);
        $query->andFilterWhere(['like', 'qtdMonitorBolsista', $this->qtdMonitorBolsista]);
        $query->andFilterWhere(['like', 'qtdMonitorNaoBolsista', $this->qtdMonitorNaoBolsista]);
        $query->andFilterWhere(['like', 'lab_traducao', $this->lab_traducao]);  */

        return $dataProvider;
    }
}
