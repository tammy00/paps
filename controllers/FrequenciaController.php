<?php

namespace app\controllers;

use Yii;
use app\models\Frequencia;
use app\models\FrequenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Aluno;
use app\models\Monitoria;
/**
 * FrequenciaController implements the CRUD actions for Frequencia model.
 */
class FrequenciaController extends Controller
{
    public function behaviors()
    {
        return [
            'acess' => [
                'class' => AccessControl::className(),
                'only' => ['create','index','update', 'delete', 'view', 'minhasfrequencias'],
                'rules' => [
                    [
                        'actions' => ['create','index','update', 'delete', 'view', 'minhasfrequencias'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest)
                            {
                                return Yii::$app->user->identity->perfil == 0; // Só adms podem acessar esse controller
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Frequencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        // Deixar essa pesquisa mais limpa

        $aluno = Aluno::find()->where(['CPF' => Yii::$app->user->identity->login])->one(); // pesquisa para pegar o id do aluno
        $rgmonitoria = Monitoria::find()->where(['IDAluno' => $aluno->ID])->one(); // pesquisa para pegar o id de monitoria do aluno
        $todas = Frequencia::find()->where(['IDMonitoria' => $rgmonitoria->ID])->all();  
        //$todas = Frequencia::find()->all();

        $frequencias = array();
        
        foreach ($todas as $freq) 
        {
            $evento = new \yii2fullcalendar\models\Event();
            $evento->id = $freq->ID;
            $evento->className = 'btn';
            $evento->title = $freq->ch .'h';
            $evento->start = $freq->dmy; 
            $frequencias[] = $evento;
        }

        return $this->render('index', [
            'events' => $frequencias,
        ]);  
        /*
        $events = array();
        //Testing
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 1;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z');
        $events[] = $Event;

        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 2;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;    
          return $this->render('index', [
            'events' => $events,
        ]);   */
    }

    /**
     * Displays a single Frequencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Frequencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Frequencia();

        $aluno = Aluno::find()->where(['CPF' => Yii::$app->user->identity->login])->one(); // pesquisa para pegar o id do aluno
        $moni = Monitoria::find()->where(['IDAluno' => $aluno->ID])->one(); // pesquisa para pegar o id de monitoria do aluno

        $model->dmy = $date;
        $model->IDMonitoria = $moni->ID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['index']);
        } 
        else 
        {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }  
    }

    /**
     * Updates an existing Frequencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //g

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Frequencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Frequencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Frequencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Frequencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página requisitada não existe.');
        }
    }

    public function actionMinhasfrequencias()
    {
        $searchModel = new FrequenciaSearch();
        $dataProvider = $searchModel->searchMinhasFrequencias(Yii::$app->request->queryParams);

        return $this->render('minhasfrequencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}