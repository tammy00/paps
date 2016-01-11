<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProfessorMonitoria;
use app\models\Usuario;

/**
 * ProfessorMonitoriaSearch represents the model behind the search form about `app\models\ProfessorMonitoria`.
 */
class ProfessorMonitoriaSearch extends ProfessorMonitoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nomeDisciplina', 'aluno', 'matricula', 'codTurma', 'nomeCursoDisciplina', 'nomeCursoAluno', 'bolsa_traducao', 'periodo'], 'safe'],
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
        $query = ProfessorMonitoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //Pega o id do usuario baseando-se no CPF do usuário logado
        $usuario = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

        $query->andFilterWhere([
            'id' => $this->id,
            'idProfessor' => $usuario->id,
        ]);

        $query->andFilterWhere(['like', 'aluno', $this->aluno]);
        $query->andFilterWhere(['like', 'matricula', $this->matricula]);
        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);
        $query->andFilterWhere(['like', 'nomeCursoDisciplina', $this->nomeCursoDisciplina]);
        $query->andFilterWhere(['like', 'nomeCursoAluno', $this->nomeCursoAluno]);
        $query->andFilterWhere(['like', 'bolsa_traducao', $this->bolsa_traducao]);
        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }

    public function searchSecretaria($params)
    {
        $query = ProfessorMonitoria::find();

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
        ]);

        $query->andFilterWhere(['like', 'aluno', $this->aluno]);
        $query->andFilterWhere(['like', 'matricula', $this->matricula]);
        $query->andFilterWhere(['like', 'cpfProfessor', $this->cpfProfessor]);
        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);
        $query->andFilterWhere(['like', 'professor', $this->professor]);
        $query->andFilterWhere(['like', 'nomeCursoDisciplina', $this->nomeCursoDisciplina]);
        $query->andFilterWhere(['like', 'nomeCursoAluno', $this->nomeCursoAluno]);
        $query->andFilterWhere(['like', 'bolsa_traducao', $this->bolsa_traducao]);
        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
