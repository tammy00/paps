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

        $COD_CURSO = null;
        $NOME_DOCENTE = null;
        $COD_DISCIPLINA = null;
        $COD_TURMA = null;
        $NOME_UNIDADE = null;
        $NOME_DISCIPLINA = null;
        $ANO = null;
        $CH_TOTAL = null;
        $CREDITOS = null;
        $PERIODO = null;
        $DT_INICIO_PERIODO = null;
        $DT_FIM_PERIODO = null;
        $VAGAS_OFERECIDAS = null;
        $NOME_CURSO_DIPLOMA = null;

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

                    $loop=0;

                    while( ($data = fgetcsv($handle, 0, ";")) != FALSE) {

                        $loop++;

                        //Encontra os índices das colunas
                        if ($loop == 1) {
                            foreach ($data as $key => $value) {
                                switch ($value) {
                                    case trim(strtoupper('COD_CURSO')):
                                        $COD_CURSO=$key;
                                        break;
                                    case trim(strtoupper('NOME_CURSO_DIPLOMA')):
                                        $NOME_CURSO_DIPLOMA=$key;
                                        break;
                                    case trim(strtoupper('NOME_DOCENTE')):
                                        $NOME_DOCENTE=$key;
                                        break;
                                    case trim(strtoupper('COD_DISCIPLINA')):
                                        $COD_DISCIPLINA=$key;
                                        break;
                                    case trim(strtoupper('COD_TURMA')):
                                        $COD_TURMA=$key;
                                        break;
                                    case trim(strtoupper('NOME_UNIDADE')):
                                        $NOME_UNIDADE=$key;
                                        break;
                                    case trim(strtoupper('NOME_DISCIPLINA')):
                                        $NOME_DISCIPLINA=$key;
                                        break;
                                    case trim(strtoupper('ANO')):
                                        $ANO=$key;
                                        break;
                                    case trim(strtoupper('PERIODO')):
                                        $PERIODO=$key;
                                        break;
                                    case trim(strtoupper('CH_TOTAL')):
                                        $CH_TOTAL=$key;
                                        break;
                                    case trim(strtoupper('CREDITOS')):
                                        $CREDITOS=$key;
                                        break;
                                    case trim(strtoupper('DT_INICIO_PERIODO')):
                                        $DT_INICIO_PERIODO=$key;
                                        break;
                                    case trim(strtoupper('DT_FIM_PERIODO')):
                                        $DT_FIM_PERIODO=$key;
                                        break;
                                    case trim(strtoupper('VAGAS_OFERECIDAS')):
                                        $VAGAS_OFERECIDAS=$key;
                                        break;
                                }
                            }

                            //Se registro de cabeçalho está inválido, então o arquivo está inválido e o procedimento é encerrado.
                            if (is_null($COD_DISCIPLINA) || is_null($NOME_DISCIPLINA) || is_null($COD_TURMA) 
                                || is_null($PERIODO) || is_null($ANO) || is_null($DT_INICIO_PERIODO) 
                                || is_null($DT_FIM_PERIODO) || is_null($COD_CURSO) || is_null($NOME_DOCENTE)) 
                            {
                                $model->addError('file', 'O cabeçalho do arquivo está inválido. Coluna(s) obrigatória(s) ausente(s). Colunas obrigatórias: COD_DISCIPLINA, NOME_DISCIPLINA, COD_TURMA, PERIODO, ANO, DT_INICIO_PERIODO, DT_FIM_PERIODO, COD_CURSO, NOME_DOCENTE');
                                break;
                            } 
                            else 
                            {
                                continue; //É a linha de cabeçalho, então vai para o próximo registro.
                            }
                        }

                        if (count($data) == 1)
                            continue; //Linha vazia, então vai para o próximo registro.

                        //$nomeUnidade = trim(utf8_encode(addslashes(strtoupper($data[0]))));
                        //if ($nomeUnidade == 'NOME_UNIDADE')
                        //    continue; //Linha de cabeçalho, então vai para o próximo registro.

                        $nomeUnidade = '';
                        $codDisciplina = '';
                        $nomeDisciplina = '';
                        $cargaHoraria = '';
                        $creditos = '';
                        $codTurma = '';
                        $qtdVagas = '';
                        $numPeriodo = '';
                        $anoPeriodo = '';
                        $date1 = '';
                        $date2 = '';
                        $codigoCurso = '';
                        $nomeCurso = '';
                        $nomeProfessor = '';

                        if ($NOME_UNIDADE != null)
                            $nomeUnidade = trim(utf8_encode(addslashes(strtoupper($data[$NOME_UNIDADE]))));
                        if ($COD_DISCIPLINA != null)
                            $codDisciplina = trim(utf8_encode(addslashes(strtoupper($data[$COD_DISCIPLINA]))));
                        if ($NOME_DISCIPLINA != null)
                            $nomeDisciplina = trim(utf8_encode(addslashes(strtoupper($data[$NOME_DISCIPLINA]))));
                        if ($CH_TOTAL != null)
                            $cargaHoraria = $data[$CH_TOTAL];
                        if ($CREDITOS != null)
                            $creditos = $data[$CREDITOS];
                        if ($COD_TURMA != null)
                            $codTurma = trim(utf8_encode(addslashes(strtoupper($data[$COD_TURMA]))));
                        if ($VAGAS_OFERECIDAS != null)
                            $qtdVagas = $data[$VAGAS_OFERECIDAS];
                        if ($PERIODO != null)
                            $numPeriodo = substr(trim(utf8_encode(addslashes(strtoupper($data[$PERIODO])))), 0, 1);
                        if ($ANO != null)
                            $anoPeriodo = $data[$ANO];
                        if ($DT_INICIO_PERIODO != null)
                            $date1 = trim(utf8_encode(addslashes(strtoupper($data[$DT_INICIO_PERIODO]))));
                        if ($DT_FIM_PERIODO != null)
                            $date2 = trim(utf8_encode(addslashes(strtoupper($data[$DT_FIM_PERIODO]))));
                        if ($COD_CURSO != null)
                            $codigoCurso = trim(utf8_encode(addslashes(strtoupper($data[$COD_CURSO]))));
                        if ($NOME_CURSO_DIPLOMA != null)
                            $nomeCurso = trim(utf8_encode(addslashes($data[$NOME_CURSO_DIPLOMA])));
                        if ($NOME_DOCENTE != null)
                            $nomeProfessor = trim(utf8_encode(addslashes(strtoupper($data[$NOME_DOCENTE]))));

                        //Se registro inválido, então vai para o próximo registro
                        $erro = '0';
                        if (empty($codDisciplina)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna COD_DISCIPLINA está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($nomeDisciplina)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna NOME_DISCIPLINA está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($codTurma)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna COD_TURMA está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($numPeriodo)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna PERIODO está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($anoPeriodo)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna ANO está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($date1)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna DT_INICIO_PERIODO está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($date2)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna DT_FIM_PERIODO está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($codigoCurso)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna COD_CURSO está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if (empty($nomeProfessor)) {
                            $model->addError('file', 'Erro na linha '.$loop.'. O valor da coluna NOME_DOCENTE está inválido. Registro não importado.');
                            $erro = '1';
                        }
                        if ($erro == '1') {
                            continue;
                        }

                        //Formata as datas
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

                        //Procura ID do Curso
                        $query = sprintf("SELECT id FROM curso WHERE UPPER(codigo) = '%s'", $codigoCurso);
                        $idCurso = Yii::$app->db->createCommand($query)->queryScalar();

                        //INSERT Tabela: curso
                        if (!$idCurso) {
                            Yii::$app->db->createCommand()->insert('curso', ['codigo' => $codigoCurso, 'nome' => $nomeCurso, 'max_horas' => 0])->execute();
                            $query = sprintf("SELECT id FROM curso WHERE codigo = '%s'", $codigoCurso);
                            $idCurso = Yii::$app->db->createCommand($query)->queryScalar();
                        }

                        //Procura ID do Professor
                        $query = sprintf("SELECT id FROM usuario WHERE perfil = 'Professor' AND UPPER(name) = '%s'", $nomeProfessor);
                        $idProfessor = Yii::$app->db->createCommand($query)->queryScalar();

                        if (!$idProfessor) {
                            $model->addError('file', 'Erro na linha '.$loop.'. Professor ('.$nomeProfessor.') não localizado no banco de dados. Registro não importado.');
                            //Se não localizar o professor, então vai para o próximo registro
                            continue;
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
                                'idCurso' => $idCurso,
                                'idProfessor' => $idProfessor
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
                                'idCurso' => $idCurso,
                                'idProfessor' => $idProfessor
                                ];
                            Yii::$app->db->createCommand()->insert('disciplina_periodo', $arrayInsert)->execute();
                        }
                    }
                    fclose($handle);
                    unlink($model->file_import); //Apaga o arquivo

                    //$columnNameArray1 = ['codDisciplina', 'nomeDisciplina', 'cargaHoraria', 'creditos'];
                    //Yii::$app->db->createCommand()->batchInsert('disciplina', $columnNameArray1, $bulkInsertArray)->execute();

                    //$columnNameArray2 = ['idDisciplina', 'numPeriodo', 'anoPeriodo', 'codTurma', 'nomeUnidade', 'qtdVagas', 'dataInicioPeriodo', 'dataFimPeriodo', 'idCurso'];
                    //Yii::$app->db->createCommand()->batchInsert('disciplina_periodo', $columnNameArray2, $bulkInsertArray2)->execute();
                }
            }

            //return $this->redirect(['index']);
            $terminou='1';
            return $this->render('importarcsv', ['model' => $model, 'fimprocessamento' => $terminou]);
        } else {
            $terminou='0';
            return $this->render('importarcsv', ['model' => $model, 'fimprocessamento' => $terminou]);
        }
    }
}
