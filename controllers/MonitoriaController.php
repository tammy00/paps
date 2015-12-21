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
use yii\helpers\Time;
use app\models\PeriodoInscricaoMonitoria;
use app\models\DisciplinaPeriodo;
use app\models\DisciplinaPeriodoSearch;
use app\models\Usuario;
use app\models\DisciplinaMonitoria;
use app\models\DisciplinaMonitoriaSearch;
use app\models\AlunoMonitoria;
use app\models\AlunoMonitoriaSearch;
use app\models\Periodo;
use mPDF;

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
                'only' => ['create','index','update', 'view', 'delete', 'inscricaoaluno', 'inscricaosecretaria'],
                'rules' => [
                    [
                        'actions' => ['create','index','update', 'view', 'delete', 'inscricaoaluno', 'inscricaosecretaria'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) 
                        {
                            if (!Yii::$app->user->isGuest)
                            {
                                if ( Yii::$app->user->identity->perfil === 'Secretaria' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Secretaria'; 
                                }
                                else  return Yii::$app->user->identity->perfil == 'Aluno'; 
                            }
                            //else -> redirecionar para o site/cpf
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

        //$model = DisciplinaMonitoria::findOne($id)

        //return $this->render('view', [
        //    'model' => $model,
        //]);
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

            //$attributes = ['IDDisc'];
            //if ($model->validate($attributes)) {

            if (Yii::$app->request->post('step') == '1') {

                //Usuario - Pega aluno baseando-se no CPF do usuário logado
                $aluno = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
                $model->IDAluno = $aluno->id;

                //Status - Aguardando Avaliação
                $model->status = 0;

                //Seleciona o último período de inscrição
                $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
                $model->IDperiodoinscr = $periodoInscricao->id;
                
                //$model->IDDisc = Yii::$app->request->post('id');
                //$monitoria = DisciplinaMonitoria::find()->where(['id' => Yii::$app->request->post('id')])->one();
                $monitoria = DisciplinaMonitoria::find()->where(['id' => $model->IDDisc])->one();
                $model->nomeDisciplina = $monitoria->nomeDisciplina;
                $model->nomeProfessor = $monitoria->nomeProfessor;

                return $this->render('create', [
                    'model' => $model,
                    'etapa' => '2',
                    'periodo' => $periodoInscricao->ano .'/'. $periodoInscricao->periodo,
                    'matricula' => $aluno->matricula,
                ]);

            } else if (Yii::$app->request->post('step') == '2') {

                //Usuario - Pega aluno baseando-se no CPF do usuário logado
                $aluno = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

                //Arquivo Histórico
                //Habilitar "extension=php_fileinfo.dll" em C:\xampp\php\php.ini
                $model->file = UploadedFile::getInstance($model, 'file');
                //$model->file->saveAs('uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension);
                $model->pathArqHistorico = 'uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension;
                //$model->file = 'uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension;

                $model->datacriacao = date('Y-d-m H:i:s');

                //if ($model->validate()) {
                    //Número do Processo
                    //$model->numProcs = date("Y").'/'.str_pad(strval($proxProcesso = Monitoria::find()->count() + 1), 6, '0', STR_PAD_LEFT);
                //}

                if ($model->save()) 
                {
                    $model->file->saveAs('uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension);
                    //return $this->redirect(['inscricaoaluno']);
                    return $this->redirect(['view', 'id' => $model->id]);

                } else {

                    if ($model->errors) {
                        //Yii::$app->getSession()->setFlash('danger', $this->convert_multi_array($model->errors));
                        //foreach ($model->getErrors() as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - '.$value);
                        //}
                        //foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        //    echo '<div class="alert alert-' . $key . '" role="alert">' . $message . '</div>';
                        //}

                        //['IDAluno', 'IDDisc', 'status', 'IDperiodoinscr', 'semestreConclusao', 'anoConclusao', 'mediaFinal']

                        //foreach ($model->getErrors('IDAluno') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - IDAluno: '.$value);
                        //}
                        //foreach ($model->getErrors('IDDisc') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - IDDisc: '.$value);
                        //}
                        //foreach ($model->getErrors('status') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - status: '.$value);
                        //}
                        //foreach ($model->getErrors('IDperiodoinscr') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - IDperiodoinscr: '.$value);
                        //}
                        //foreach ($model->getErrors('semestreConclusao') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - semestreConclusao: '.$value);
                        //}
                        //foreach ($model->getErrors('anoConclusao') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - anoConclusao: '.$value);
                        //}
                        //foreach ($model->getErrors('mediaFinal') as $key => $value) {
                        //    Yii::$app->getSession()->setFlash('danger', $key.' - mediaFinal: '.$value);
                        //}

                        //foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        //    echo '<div class="alert alert-' . $key . '" role="alert">' . $message . '</div>';
                        //}

                        //Usuario - Pega aluno baseando-se no CPF do usuário logado
                        $aluno = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

                        //Seleciona o último período de inscrição
                        $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();

                        return $this->render('create', [
                        'model' => $model,
                        'etapa' => '2',
                        'periodo' => $periodoInscricao->ano .'/'. $periodoInscricao->periodo,
                        'matricula' => $aluno->matricula,
                        ]);

                    }
                }
            }
        } else {

            //Usuario - Pega aluno baseando-se no CPF do usuário logado
            $aluno = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
            $model->IDAluno = $aluno->id;

            //Status - Aguardando Avaliação
            $model->status = 0;

            //Seleciona o último período de inscrição
            $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
            $model->IDperiodoinscr = $periodoInscricao->id;

            $searchModel = new DisciplinaMonitoriaSearch();
            $searchModel->numPeriodo = $periodoInscricao->periodo;
            $searchModel->anoPeriodo = $periodoInscricao->ano;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('create', [
                'model' => $model,
                'etapa' => '1',
                'periodo' => $periodoInscricao->ano .'/'. $periodoInscricao->periodo,
                'matricula' => $aluno->matricula,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
        if ( (Yii::$app->request->referrer) != '/monitoria/inscricaoaluno')
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save() ) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                //Usuario - Pega aluno baseando-se no CPF do usuário logado
                $aluno = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

                //Seleciona o último período de inscrição
                $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();

                return $this->render('update', [
                    'model' => $model,
                    'etapa' => '1',
                    'periodo' => $periodoInscricao->ano .'/'. $periodoInscricao->periodo,
                    'matricula' => $aluno->matricula,
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

    public function actionInscricaoaluno()
    {
        $searchModel = new AlunoMonitoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('inscricaoaluno', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendencias() 
    {
        $searchModel = new MonitoriaSearch();
        $dataProvider = $searchModel->searchPendencias(Yii::$app->request->queryParams);

        return $this->render('pendencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInscricaosecretaria()
    {
        $searchModel = new MonitoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('inscricaosecretaria', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }  

    public function actionDeferir($id)
    {
        Yii::$app->db->createCommand()->update('monitoria', ['status' => 1], 'id='.$id)->execute();

        return$this->actionPendencias();
    }

    public function actionIndeferir($id)
    {
        Yii::$app->db->createCommand()->update('monitoria', ['status' => 2], 'id='.$id)->execute();
        
        return$this->actionPendencias();
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
        //$modelPeriodo = Periodo::find()->orderBy(['id' => SORT_DESC])->one();
        //$dadosCabecalho = DisciplinaPeriodo::find()->where(['anoPeriodo'.'/'.'numPeriodo' => $modelPeriodo->codigo])->one();

        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();

        if ( $dadosCabecalho != null ) {

            $cssfile = file_get_contents('../web/css/estilo3.css');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->title = '3. Quadro Geral';
            $mpdf->WriteHTML($cssfile, 1);
            //$mpdf->Image('../web/img/cabecalho.png', 20, 5, 900, 80);
            $mpdf->WriteHTML('
                <img src="../web/img/cabecalho.png" alt="Universidade Federal do Amazonas...." width="950" height="80">
                <p><b>QUADRO GERAL DE MONITORES BOLSISTAS E NÃO BOLSISTAS - 03<br>
                (<amarelo>Encaminhar também em formato .DOC -word- para o email monitoriaufam@outlook.com</amarelo>)
                </b></p>
                <table>
                    <tr>
                      <td bgcolor="#e6e6e6"> <b>SETOR RESPONSÁVEL (Coord.Dept/Outros)</b> </td>
                      <td> '.$modelPeriodo->nomeUnidade.'</td>
                      <td bgcolor="#e6e6e6"><b>UNIDADE</b></td>
                      <td>'.$modelPeriodo->nomeUnidade.'</td>
                    </tr>
                    <tr>
                      <td bgcolor="#e6e6e6"><b>PERÍODO LETIVO</b></td>
                      <td colspan=3>'.$modelPeriodo->anoPeriodo.'/'.$modelPeriodo->numPeriodo.' </td> 
                     </tr>  
                 </table>

            ');

            $mpdf->Output();
            exit;
        }
        else return $this->render('gerarquadrogeral');
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
