<?php

namespace app\controllers;

use Yii;
use app\models\PeriodoInscricaoMonitoria;
use app\models\PeriodoInscricaoMonitoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PeriodoInscricaoMonitoriaController implements the CRUD actions for PeriodoInscricaoMonitoria model.
 */
class PeriodoInscricaoMonitoriaController extends Controller
{
    public function behaviors()
    {
        return [
            'acess' => [
                'class' => AccessControl::className(),
                'only' => ['create','index','update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create','index','update', 'view', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest)
                            {
                                if ( Yii::$app->user->identity->perfil === 'Secretaria' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Secretaria'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'Coordenador' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Coordenador'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'admin' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'admin'; 
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
     * Lists all PeriodoInscricaoMonitoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeriodoInscricaoMonitoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PeriodoInscricaoMonitoria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $m = $this->findModel($id);
        $m->dataInicio = Yii::$app->formatter->asDate($m->dataInicio, 'php:d-m-Y');
        $m->dataFim = Yii::$app->formatter->asDate($m->dataFim, 'php:d-m-Y');
        return $this->render('view', [
            'model' => $m,
        ]);
    }

    /**
     * Creates a new PeriodoInscricaoMonitoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PeriodoInscricaoMonitoria();

        if ($model->load(Yii::$app->request->post()) ) 
        {
            if ( (strtotime($model->dataInicio) >= time()) && ( strtotime($model->dataInicio) < strtotime($model->dataFim) ) 
                && (strtotime($model->dataFim) > time() ) && (strtotime($model->dataInicio) != strtotime($model->dataFim)) 
                && $model->ano = date('Y', strtotime($model->dataInicio)) )
            {
                $model->dataInicio = Yii::$app->formatter->asDate($model->dataInicio, 'php:Y-m-d');
                $model->dataFim = Yii::$app->formatter->asDate($model->dataFim, 'php:Y-m-d');
                //$model->ano = date('Y', strtotime($model->dataInicio));
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                $model->delete();
                return $this->render('aviso');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PeriodoInscricaoMonitoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) 
        {
            if ( (strtotime($model->dataInicio) >= time()) && ( strtotime($model->dataInicio) < strtotime($model->dataFim) ) 
                && (strtotime($model->dataFim) > time() ) && (strtotime($model->dataInicio) != strtotime($model->dataFim)) )
            {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('aviso');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PeriodoInscricaoMonitoria model.
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
     * Finds the PeriodoInscricaoMonitoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PeriodoInscricaoMonitoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PeriodoInscricaoMonitoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página requistada não existe.');
        }
    }
}
