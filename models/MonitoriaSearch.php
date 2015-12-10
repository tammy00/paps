<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Monitoria;
use app\models\Usuario;
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
            [['id', 'IDAluno', 'IDperiodoinscr'], 'integer'],
            [['IDDisc', 'nomeCurso'], 'safe'],
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
            'id' => $this->id,
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

        //Pega o id do usuario baseando-se no CPF do usuário logado
        $usuario = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

        $query->joinWith(['usuario']);
        $query->joinWith(['disciplinaperiodo']);
        $query->joinWith(['periodoinscricao']);
        $query->leftJoin('disciplina', 'disciplina.id = disciplina_periodo.idDisciplina');
        $query->leftJoin('curso', 'curso.id = disciplina_periodo.idCurso');

        $query->andFilterWhere([
            'id' => $this->id,
            'IDAluno' => $usuario->id,
            //'IDDisc' => $this->IDDisc,
            //'bolsa' => $this->bolsa,
            //'status' => $this->status,
            //'IDperiodoinscr' => $this->IDperiodoinscr,
        ]);

        $query->andFilterWhere(['like', 'usuario.name', $this->IDAluno]);
        $query->andFilterWhere(['like', 'disciplina.nomeDisciplina', $this->IDDisc]);
        $query->andFilterWhere(['like', 'curso.nome', $this->nomeCurso]);
        $query->andFilterWhere(['like', 'periodoinscricao.ano', $this->IDperiodoinscr]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
