<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DisciplinaPeriodo;

/**
 * DisciplinaPeriodoSearch represents the model behind the search form about `app\models\DisciplinaPeriodo`.
 */
class DisciplinaPeriodoSearch extends DisciplinaPeriodo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'qtdVagas', 'numPeriodo', 'anoPeriodo', 'usaLaboratorio'], 'integer'],
            [['codTurma', 'nomeUnidade', 'dataInicioPeriodo', 'dataFimPeriodo', 'idDisciplina', 'idCurso', 'idProfessor'], 'safe'],
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
        $query = DisciplinaPeriodo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['disciplina']);
        $query->joinWith(['curso']);
        $query->joinWith(['usuario']);

        $query->andFilterWhere([
            'id' => $this->id,
            //'idDisciplina' => $this->idDisciplina,
            //'idCurso' => $this->idCurso,
            //'idProfessor' => $this->idProfessor,
            'qtdVagas' => $this->qtdVagas,
            'numPeriodo' => $this->numPeriodo,
            'anoPeriodo' => $this->anoPeriodo,
            'dataInicioPeriodo' => $this->dataInicioPeriodo,
            'dataFimPeriodo' => $this->dataFimPeriodo,
            'usaLaboratorio' => $this->usaLaboratorio,
        ]);

        $query->andFilterWhere(['like', 'codTurma', $this->codTurma])
            ->andFilterWhere(['like', 'nomeUnidade', $this->nomeUnidade]);

        $query->andFilterWhere(['like', 'disciplina.nomeDisciplina', $this->idDisciplina]);
        $query->andFilterWhere(['like', 'curso.nome', $this->idCurso]);
        $query->andFilterWhere(['like', 'usuario.name', $this->idProfessor]);

        return $dataProvider;
    }
}
