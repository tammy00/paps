<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Frequencia;

/**
 * FrequenciaSearch represents the model behind the search form about `app\models\Frequencia`.
 */
class FrequenciaSearch extends Frequencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'IDMonitoria'], 'integer'],
            [['dmy', 'atividade'], 'safe'],
            [['ch'], 'number'],
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
        $query = Frequencia::find();

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
            'IDMonitoria' => $this->IDMonitoria,
            'dmy' => $this->data,
            'ch' => $this->ch,
        ]);

        $query->andFilterWhere(['like', 'atividade', $this->atividade]);

        return $dataProvider;
    }

    public function searchMinhasFrequencias($params)
    {
        $query = Frequencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $aluno = Aluno::findOne(['CPF' => Yii::$app->user->identity->login]);
        $monitoria = Monitoria::findOne(['IDAluno' => $aluno->ID]);

        $query->andFilterWhere([
            'ID' => $this->ID,
            'IDMonitoria' => $monitoria->ID,
            'dmy' => $this->dmy,
            'ch' => $this->ch,
            'atividade' => $this->atividade,
        ]);

        $query->orderBy(['ID' => SORT_DESC]);

        return $dataProvider;
    }
}
