<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlunoMonitoria;
use app\models\Usuario;

/**
 * AlunoMonitoriaSearch represents the model behind the search form about `app\models\AlunoMonitoria`.
 */
class AlunoMonitoriaSearch extends AlunoMonitoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['aluno', 'matricula', 'cpf', 'nomeDisciplina', 'codTurma', 'professor', 'nomeCurso', 'bolsa_traducao', 'status', 'periodo'], 'safe'],
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
    public function searchAluno($params)
    {
        $query = AlunoMonitoria::find();

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
            'IDAluno' => $usuario->id,
        ]);

        $query->andFilterWhere(['like', 'aluno', $this->aluno]);
        $query->andFilterWhere(['like', 'matricula', $this->matricula]);
        $query->andFilterWhere(['like', 'cpf', $this->cpf]);
        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);
        $query->andFilterWhere(['like', 'professor', $this->professor]);
        $query->andFilterWhere(['like', 'nomeCurso', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'bolsa_traducao', $this->bolsa_traducao]);
        $query->andFilterWhere(['like', 'status', $this->status]);
        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        //$query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }

    public function searchSecretaria($params)
    {
        $query = AlunoMonitoria::find();

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
            'IDperiodoinscr' => $this->IDperiodoinscr,
        ]);

        $query->andFilterWhere(['like', 'aluno', $this->aluno]);
        $query->andFilterWhere(['like', 'matricula', $this->matricula]);
        $query->andFilterWhere(['like', 'cpf', $this->cpf]);
        $query->andFilterWhere(['like', 'nomeDisciplina', $this->nomeDisciplina]);
        $query->andFilterWhere(['like', 'codTurma', $this->codTurma]);
        $query->andFilterWhere(['like', 'professor', $this->professor]);
        $query->andFilterWhere(['like', 'nomeCurso', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'bolsa_traducao', $this->bolsa_traducao]);
        $query->andFilterWhere(['like', 'status', $this->status]);
        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        //$query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
