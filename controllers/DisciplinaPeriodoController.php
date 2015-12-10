<?php

namespace app\controllers;

use Yii;
use app\models\DisciplinaPeriodo;
use app\models\DisciplinaPeriodoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Command;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\bootstrap\Alert;

use app\models\Disciplina;
use app\models\DisciplinaSearch;
use app\models\Curso;
use app\models\CursoSearch;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\filters\AccessControl;

/**
 * DisciplinaPeriodoController implements the CRUD actions for DisciplinaPeriodo model.
 */
class DisciplinaPeriodoController extends Controller
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
                                return Yii::$app->user->identity->perfil == 'Secretaria'; // Só adms podem acessar esse controller
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
     * Lists all DisciplinaPeriodo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisciplinaPeriodoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DisciplinaPeriodo model.
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
     * Creates a new DisciplinaPeriodo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DisciplinaPeriodo();
        $model->scenario = 'default';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            //if ($model->errors) {
            //    //Yii::$app->getSession()->setFlash('danger', $this->convert_multi_array($model->errors));
            //    foreach ($model->getErrors() as $key => $value) {
            //        Yii::$app->getSession()->setFlash('danger', $key.' - '.$value);
            //    }

            //    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            //        echo '<div class="alert alert-' . $key . '" role="alert">' . $message . '</div>';
            //    }
            //} else {
                return $this->render('create', ['model' => $model]);
            //}
        }
    }

    public function convert_multi_array($array) {
      $out = implode("&",array_map(function($a) {return implode("~",$a);},$array));
      return $out;
    }

    /**
     * Updates an existing DisciplinaPeriodo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'default';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing DisciplinaPeriodo model.
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
     * Finds the DisciplinaPeriodo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisciplinaPeriodo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DisciplinaPeriodo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImportarcsv()
    {
        $model = new DisciplinaPeriodo(['scenario' => 'csv']);        

        /*
        if (Yii::$app->request->get('success') != null) { 
            return $this->render('importarcsv', [
                'model' => $model,
                'success' => $success]);
        } else {
            return $this->render('importarcsv', [
                'model' => $model,
                'success' => '']);
        }
        */

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            $uploadExists = 0;
            
            if($model->file) {
                $imagepath = 'uploads/disciplinas-periodo/';
                $model->file_import = $imagepath .rand(10,1000).'-'.str_replace('','-',$model->file->name);
                $bulkInsertArray = array();
                $bulkInsertArray2 = array();
                $uploadExists = 1;
            }

            if($uploadExists) {

                $model->file->saveAs($model->file_import);

                $handle = fopen($model->file_import, 'r');
                if ($handle) {                

                    while( ($data = fgetcsv($handle, 0, ",")) != FALSE) {

                        $nomeUnidade = trim(utf8_encode(addslashes(strtoupper($data[0]))));

                        if ($nomeUnidade == 'NOME_UNIDADE')
                            continue; //Linha de cabeçalho, então vai para o próximo registro.

                        $codDisciplina = trim(utf8_encode(addslashes(strtoupper($data[5]))));
                        $nomeDisciplina = trim(utf8_encode(addslashes(strtoupper($data[1]))));
                        $cargaHoraria = $data[13];
                        $creditos = $data[14];
                        $codTurma = trim(utf8_encode(addslashes(strtoupper($data[2]))));
                        $qtdVagas = $data[23];
                        $numPeriodo = substr(trim(utf8_encode(addslashes(strtoupper($data[15])))), 0, 1);
                        $anoPeriodo = $data[10];
                        $date1 = trim(utf8_encode(addslashes(strtoupper($data[18]))));
                        $date2 = trim(utf8_encode(addslashes(strtoupper($data[19]))));

                        if ($date1 != null && !empty($date1)) {
                            $arrayDate = explode("/", $date1);
                            $dataInicioPeriodo = $arrayDate[2].'-'.$arrayDate[1].'-'.$arrayDate[0];
                        } else {
                            $dataInicioPeriodo = null;
                        }

                        if ($date2 != null && !empty($date2)) {
                            $arrayDate = explode("/", $date2);
                            $dataFimPeriodo = $arrayDate[2].'-'.$arrayDate[1].'-'.$arrayDate[0];
                        } else {
                            $dataFimPeriodo = null;
                        }

                        $siglaCurso = trim(utf8_encode(addslashes(strtoupper($data[16]))));
                        $query = sprintf("SELECT id FROM curso WHERE codigo = '%s'", $siglaCurso);
                        $idCurso = Yii::$app->db->createCommand($query)->queryScalar();

                        //Tabela: curso
                        if (!$idCurso) {
                            Yii::$app->db->createCommand()->insert('curso', ['codigo' => $siglaCurso])->execute();
                            $query = sprintf("SELECT id FROM curso WHERE codigo = '%s'", $siglaCurso);
                            $idCurso = Yii::$app->db->createCommand($query)->queryScalar();
                        }

                        //Tabela: disciplina
                        $query = sprintf("SELECT id FROM disciplina WHERE codDisciplina = '%s'", $codDisciplina);
                        $idDisciplina = Yii::$app->db->createCommand($query)->queryScalar();

                        if ($idDisciplina) {
                            $arrayUpdate = ['nomeDisciplina' => $nomeDisciplina, 'cargaHoraria' => $cargaHoraria, 'creditos' => $creditos];
                            Yii::$app->db->createCommand()->update('disciplina', $arrayUpdate, 'id='.$idDisciplina)->execute();
                        } else {
                            
                            //if (array_search($codDisciplina, array_column($bulkInsertArray, 'codDisciplina'))) {
                            //    $bulkInsertArray[]=[
                            //       'codDisciplina' => $codDisciplina,
                            //       'nomeDisciplina' => $nomeDisciplina,
                            //       'cargaHoraria' => $cargaHoraria,
                            //       'creditos' => $creditos,
                            //   ];
                            //}

                            $arrayInsert = [
                                'codDisciplina' => $codDisciplina, 
                                'nomeDisciplina' => $nomeDisciplina, 
                                'cargaHoraria' => $cargaHoraria, 
                                'creditos' => $creditos
                            ];
                            Yii::$app->db->createCommand()->insert('disciplina', $arrayInsert)->execute();
                        }

                        //Tabela: disciplina_periodo

                        $query = sprintf("SELECT id FROM disciplina WHERE codDisciplina = '%s'", $codDisciplina);
                        $idDisciplina = Yii::$app->db->createCommand($query)->queryScalar();

                        $query = sprintf("SELECT id FROM disciplina_periodo WHERE idDisciplina='%s' and codTurma='%s' and anoPeriodo='%s' and numPeriodo='%s'", 
                            $idDisciplina, $codTurma, $anoPeriodo, $numPeriodo);

                        $result = Yii::$app->db->createCommand($query)->queryScalar();

                        if ($result) {
                            $arrayUpdate = [
                                'nomeUnidade' => $nomeUnidade,
                                'qtdVagas' => $qtdVagas, 
                                'dataInicioPeriodo' => $dataInicioPeriodo, 
                                'dataFimPeriodo' => $dataFimPeriodo, 
                                'idCurso' => $idCurso
                                ];
                            Yii::$app->db->createCommand()->update('disciplina_periodo', $arrayUpdate, 'id='.$result)->execute();
                        } else {
                            
                            //if (array_search($idDisciplina, array_column($bulkInsertArray2, 'idDisciplina'))) {
                            //    $bulkInsertArray2[]=[
                            //        'idDisciplina' => $idDisciplina,
                            //        'numPeriodo' => $numPeriodo,
                            //        'anoPeriodo' => $anoPeriodo,
                            //        'codTurma' => $codTurma,
                            //        'nomeUnidade' => $nomeUnidade,
                            //        'qtdVagas' => $qtdVagas, 
                            //        'dataInicioPeriodo' => $dataInicioPeriodo, 
                            //        'dataFimPeriodo' => $dataFimPeriodo, 
                            //        'idCurso' => $idCurso
                            //    ];
                            //}

                            $arrayInsert = [
                                'idDisciplina' => $idDisciplina,
                                'numPeriodo' => $numPeriodo,
                                'anoPeriodo' => $anoPeriodo,
                                'codTurma' => $codTurma,
                                'nomeUnidade' => $nomeUnidade,
                                'qtdVagas' => $qtdVagas, 
                                'dataInicioPeriodo' => $dataInicioPeriodo, 
                                'dataFimPeriodo' => $dataFimPeriodo, 
                                'idCurso' => $idCurso
                                ];
                            Yii::$app->db->createCommand()->insert('disciplina_periodo', $arrayInsert)->execute();
                        }
                    }
                    fclose($handle);

                    //$columnNameArray1 = ['codDisciplina', 'nomeDisciplina', 'cargaHoraria', 'creditos'];
                    //Yii::$app->db->createCommand()->batchInsert('disciplina', $columnNameArray1, $bulkInsertArray)->execute();

                    //$columnNameArray2 = ['idDisciplina', 'numPeriodo', 'anoPeriodo', 'codTurma', 'nomeUnidade', 'qtdVagas', 'dataInicioPeriodo', 'dataFimPeriodo', 'idCurso'];
                    //Yii::$app->db->createCommand()->batchInsert('disciplina_periodo', $columnNameArray2, $bulkInsertArray2)->execute();
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('importarcsv', ['model' => $model]);
        }
    }
}
