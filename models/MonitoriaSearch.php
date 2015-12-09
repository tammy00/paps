<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Monitoria;
use app\models\Aluno;
use app\models\Disciplina;
use app\models\DisciplinaPeriodo;

/**
 * MonitoriaSearch represents the model behind the search form about `app\models\Monitoria`.
 */
class MonitoriaSearch extends Monitoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'IDAluno', 'IDperiodoinscr'], 'integer'],
            [['numProcs', 'IDDisc', 'nomeCurso'], 'safe'],
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
        $query = Monitoria::find();

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
            'ID' => $this->ID,
            'IDAluno' => $this->IDAluno,
            'IDDisc' => $this->IDDisc,
            'bolsa' => $this->bolsa,
            'status' => $this->status,
            'IDperiodoinscr' => $this->IDperiodoinscr,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAluno($params)
    {
        $query = Monitoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            //return $dataProvider;
        }

        //Pega o ID do aluno baseando-se no CPF do usuário logado
        $aluno = Aluno::findOne(['CPF' => Yii::$app->user->identity->login]);

        $query->joinWith(['aluno']);
        $query->joinWith(['disciplinaperiodo']);
        $query->joinWith(['periodoinscricao']);
        $query->leftJoin('disciplina', 'disciplina.id = disciplina_periodo.idDisciplina');
        $query->leftJoin('curso', 'curso.ID = disciplina_periodo.idCurso');

        $query->andFilterWhere([
            'ID' => $this->ID,
            'IDAluno' => $aluno->ID,
            //'IDDisc' => $this->IDDisc,
            //'bolsa' => $this->bolsa,
            //'status' => $this->status,
            //'IDperiodoinscr' => $this->IDperiodoinscr,
        ]);

        $query->andFilterWhere(['like', 'numProcs', $this->numProcs]);

        $query->andFilterWhere(['like', 'aluno.nome', $this->IDAluno]);
        $query->andFilterWhere(['like', 'disciplina.nomeDisciplina', $this->IDDisc]);
        $query->andFilterWhere(['like', 'curso.nome', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'periodoinscricao.ano', $this->IDperiodoinscr]);

        $query->orderBy(['ID' => SORT_DESC]);

        return $dataProvider;
    }
}
