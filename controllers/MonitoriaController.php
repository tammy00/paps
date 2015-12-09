<?php

namespace app\controllers;

use Yii;
use app\models\Monitoria;
use app\models\MonitoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Disciplina;
use app\models\DisciplinaSearch;
use yii\helpers\ArrayHelper;
use yii\db\Command;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\PeriodoInscricaoMonitoria;
use app\models\DisciplinaPeriodo;
use app\models\DisciplinaPeriodoSearch;
use app\models\Aluno;

/**
 * MonitoriaController implements the CRUD actions for Monitoria model.
 */
class MonitoriaController extends Controller
{
    public function behaviors()
    {
        return [
            'acess' => [
                'class' => AccessControl::className(),
                'only' => ['create','index','update', 'view', 'delete', 'minhasinscricoes', 'pendencias'],
                'rules' => [
                    [
                        'actions' => ['create','index','update', 'view', 'delete', 'minhasinscricoes', 'pendencias'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) 
                        {
                            if (!Yii::$app->user->isGuest)
                            {
                                if ( Yii::$app->user->identity->perfil === 1 ) 
                                {
                                    return Yii::$app->user->identity->perfil == 1; 
                                }
                                else  return Yii::$app->user->identity->perfil == 0; 
                            }
                            //else -> redirecionar para o site/login
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
     * Lists all Monitoria models.
     * @return mixed
     */
    private $marcador = 1;
    public function actionIndex()
    {
        $searchModel = new MonitoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Monitoria model.
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
     * Creates a new Monitoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monitoria();

        if ($model->load(Yii::$app->request->post())) {

            //Arquivo Histórico
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('uploads/historicos/'.$model->file->baseName.'.'.$model->file->extension);
            $model->pathArqHistorico = $model->file->name;
            $model->file = 'uploads/historicos/'.$model->file->baseName.'.'.$model->file->extension;

            if ($model->validate()) {
                //Número do Processo
                $model->numProcs = date("Y").'/'.str_pad(strval($proxProcesso = Monitoria::find()->count() + 1), 6, '0', STR_PAD_LEFT);
            }

            if ($model->save()) 
            {
                return $this->redirect(['view', 'id' => $model->ID]);

            } else {

                if ($model->errors) {
                    Yii::$app->getSession()->setFlash('danger', $this->convert_multi_array($model->errors));
                    //foreach ($model->getErrors() as $key => $value) {
                    //    Yii::$app->getSession()->setFlash('danger', $key.' - '.$value);
                    //}
                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        echo '<div class="alert alert-' . $key . '" role="alert">' . $message . '</div>';
                    }
                }
            }
        } else {
            //Número do Processo
            $model->numProcs = '[Novo]';

            //Aluno - Pega aluno baseando-se no CPF do usuário logado
            $aluno = Aluno::findOne(['CPF' => Yii::$app->user->identity->login]);
            $model->IDAluno = $aluno->ID;

            //Status - Aguardando Avaliação
            $model->status = 0;

            //Seleciona o último período de inscrição
            $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['ID' => SORT_DESC])->one();
            $model->IDperiodoinscr = $periodoInscricao->ID;
            $periodo = $periodoInscricao->ano.'/'.$periodoInscricao->periodo;

            return $this->render('create', [
                'model' => $model,
                'periodo' => $periodo,
                'matricula' => $aluno->matricula,
                'banco' => $aluno->banco,
                'agencia' => $aluno->agencia,
                'conta' => $aluno->conta,
            ]);
        }
    }

    /**
     * Updates an existing Monitoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ( (Yii::$app->request->referrer) != '/monitoria/minhasinscricoes')
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save() ) {
                return $this->redirect(['view', 'id' => $model->ID]);
            } else {

                //Aluno - Pega aluno baseando-se no CPF do usuário logado
                $aluno = Aluno::findOne(['CPF' => Yii::$app->user->identity->login]);

                //Seleciona o último período de inscrição
                $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['ID' => SORT_DESC])->one();
                $periodo = $periodoInscricao->ano.'/'.$periodoInscricao->periodo;

                return $this->render('update', [
                    'model' => $model,
                    'periodo' => $periodo,
                    'matricula' => $aluno->matricula,
                    'banco' => $aluno->banco,
                    'agencia' => $aluno->agencia,
                    'conta' => $aluno->conta,
                ]);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Monitoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->perfil == 1) {
            $this->findModel($id)->delete();
            //$this->redirect(['index']);
        } 

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Monitoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Monitoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monitoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página requisitada não existe.');
        }
    }

    public function actionMinhasinscricoes()
    {
        $searchModel = new MonitoriaSearch();
        $dataProvider = $searchModel->searchAluno(Yii::$app->request->queryParams);

        return $this->render('minhasinscricoes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendencias() 
    {
        $searchModel = new MonitoriaSearch();
        $dataProvider = $searchModel->searchPendencias();

        return $this->render('pendencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionStatus($model)
    {
        if (Yii::$app->user->identity->perfil == 1) 
        {
            if ($model->load(Yii::$app->request->post()) && $model->save() ) {
                return $this->redirect(['view', 'id' => $model->ID]);
            }
            else $this->render('status', ['model' => $model]);
        } 

        return $this->redirect(Yii::$app->request->referrer);
    }   

    public function actionFazerplanosemestral()
    {

        return $this->render('fazerplanosemestral');
    }

    public function actionGerarplanosemestraldisciplina()
    {

        return $this->render('gerarplanosemestraldisciplina');
    }

    public function actionGerarquadrogeral()
    {

        return $this->render('gerarquadrogeral');
    }

    public function actionGerarfrequenciageral()
    {

        return $this->render('gerarfrequenciageral');
    }

    public function actionGerarrelatoriosemestral()
    {

        return $this->render('gerarrelatoriosemestral');
    }

    public function actionGerarrelatorioanual()
    {

        return $this->render('gerarrelatorioanual');
    }

    public function convert_multi_array($array) {
      $out = implode("&",array_map(function($a) {return implode("~",$a);},$array));
      return $out;
    }
}
