<?php

namespace app\controllers;

use Yii;
use app\models\Frequencia;
use app\models\FrequenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuario;
use app\models\Monitoria;
use app\models\AlunoMonitoria;
use app\models\PeriodoInscricaoMonitoria;
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
                                if ( Yii::$app->user->identity->perfil === 'Aluno' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Aluno'; 
                                }
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
    public function actionIndex($id)
    {
        // Deixar essa pesquisa mais limpa

        $frequencias = array();
        $aluno = Usuario::find()->where(['CPF' => Yii::$app->user->identity->cpf])->one(); // pesquisa para pegar o id do aluno
        
        $todas = Frequencia::find()->where(['IDMonitoria' => $id])->all();
        
        foreach ($todas as $freq) 
        {
            $evento = new \yii2fullcalendar\models\Event();
            $evento->id = $freq->id;
            $evento->allDay = true;
            $evento->className = 'btn';
            
            //$evento->title = $freq->ch .'h -' . $freq->atividade;
            if ( $freq->atividade == null ) $evento->title = $freq->ch .'h';
            else $evento->title = $freq->ch .'h -' . $freq->atividade;

            $evento->start = $freq->dmy;
            //$evento->end = date("Y-m-d", strtotime("+1 day", strtotime($freq->dmy)));
            $frequencias[] = $evento;
        }

        return $this->render('index', [
            'events' => $frequencias,
            'erro' => ($id != null ? '0' : '1'),
            'idM' => $id,
        ]);  
    }

    /**
     * Displays a single Frequencia model.
     * @param integer $id
     * @return mixed
     */
    /*
    public function actionView($id)
    {
        $m = $this->findModel($id);
        $m->dataInicio = Yii::$app->formatter->asDate($m->dataInicio, 'php:d-m-Y');
        $m->dataFim = Yii::$app->formatter->asDate($m->dataFim, 'php:d-m-Y');
        return $this->render('view', [
            'model' => $m,
        ]);
    }   */

    /**
     * Creates a new Frequencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Frequencia();
        $p = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
        //$letivo = $p->ano.'/'.$p->periodo;
        $aluno = AlunoMonitoria::find()
            ->where(['cpf' => Yii::$app->user->identity->cpf])
            ->andWhere(['IDperiodoinscr' => $p->id])
            ->andWhere(['status' => 'Deferido'])
            ->one(); // pesquisa para pegar o id do alun

        $model->dmy = $date;


        $pesquisa = Frequencia::find()->where(['IDMonitoria' => $aluno->id])->andWhere(['dmy' => $date])->one();
        // Serve para verificar se tem registro na data selecionada. 
        if ( empty($pesquisa) )
        {
            if ($model->load(Yii::$app->request->post()) ) 
            {
                    $numDia = date('w', strtotime($date));
                    $cont = $flag = 0;

                    $dia1 = strtotime('-'.$numDia.' day', strtotime($date));
                    $diaX = strtotime('+'.(6 - $numDia).' day', strtotime($date));

                    $p = Frequencia::find()
                        ->where(['IDMonitoria' => $aluno->id])
                        ->andWhere(['>=', 'dmy', date("Y-m-d",$dia1)])
                        ->andWhere(['<=', 'dmy', date("Y-m-d",$diaX)])
                        ->all();

                    foreach ($p as $f) 
                    {
                        $cont = $cont + $f->ch;
                        if ( $cont > 12 ) $flag = 1;
                    }

                    if ( $flag == 0 && ($model->ch + $cont <= 12))
                    {
                        $model->IDMonitoria = $aluno->id;
                        $model->save();
                        return $this->redirect(['index', 'id' => $model->IDMonitoria,]);  
                    }
                    else return $this->redirect(['index', 'id' => $aluno->id, 'mensagem' => 'Carga não cadastrada por conta do excesso de horas.',]);  
            }
            else return $this->renderAjax('create', [
                        'model' => $model,
                    ]);
        }
        else return $this->redirect(['index', 'id' => $aluno->id, 'mensagem' => 'Já existe registro nesta data para a sua monitoria.',]);  
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
         if ($model->load(Yii::$app->request->post()) ) 
        {
                $numDia = date('w', strtotime($model->dmy));
                $cont = $flag = 0;

                $dia1 = strtotime('-'.$numDia.' day', strtotime($model->dmy));
                $diaX = strtotime('+'.(6 - $numDia).' day', strtotime($model->dmy));

                $p = Frequencia::find()
                    ->where(['IDMonitoria' => $model->IDMonitoria])
                    ->andWhere(['>=', 'dmy', date("Y-m-d",$dia1)])
                    ->andWhere(['<=', 'dmy', date("Y-m-d",$diaX)])
                    ->all();

                foreach ($p as $f) 
                {
                    $cont = $cont + $f->ch;
                    if ( $cont > 12 ) $flag = 1;
                }

                if ( $flag == 0 && ($model->ch + $cont <= 12))
                {
                    $model->save();
                    return $this->redirect(['minhasfrequencias', 'id' => $model->IDMonitoria]);
                }
                else return $this->redirect(['index', 'id' => $model->IDMonitoria, 'mensagem' => 'Carga não cadastrada por conta do excesso de horas.',]);  
        } 
        else {
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
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $idMonitor = $model->IDMonitoria;
        $model->delete();

        return $this->redirect(['minhasfrequencias', 'id' => $idMonitor]);
        //return $this->render('monitoria\index'); 
        //return $this->redirect(['index']);
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

    public function actionMinhasfrequencias($id)
    {
        $searchModel = new FrequenciaSearch();
        $dataProvider = $searchModel->searchMinhasFrequencias(Yii::$app->request->queryParams, $id);

        return $this->render('minhasfrequencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
