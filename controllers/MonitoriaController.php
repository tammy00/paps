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
use yii\db\Expression;
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
use app\models\ProfessorMonitoria;
use app\models\ProfessorMonitoriaSearch;
use app\models\Periodo;
use app\models\Curso;
use app\models\Frequencia;
use app\models\Comissao;
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
                'only' => ['create','index','update', 'view', 'delete', 'aluno', 'secretaria', 'professor', 'avaliador', 'justificativa'],
                'rules' => [
                    [
                        'actions' => ['create','index','update', 'view', 'delete', 'aluno', 'secretaria', 'professor', 'avaliador', 'justificativa'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) 
                        {
                            if (!Yii::$app->user->isGuest)
                            {
                                if ( Yii::$app->user->identity->perfil === 'Secretaria' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Secretaria'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'Aluno' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Aluno'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'Coordenador' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Coordenador'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'Professor' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'Professor'; 
                                }
                                elseif ( Yii::$app->user->identity->perfil === 'admin' ) 
                                {
                                    return Yii::$app->user->identity->perfil == 'admin'; 
                                }
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
        //return $this->render('index');
        return $this->render('index', ['erro' => 0]);
    }

    /**
     * Displays a single Monitoria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => AlunoMonitoria::findOne($id),
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
                $model->pathArqHistorico = 'uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension;

                $model->datacriacao = date('Y-d-m H:i:s');

                //if ($model->validate()) {
                //}

                if ($model->save()) 
                {
                    $model->file->saveAs('uploads/historicos/'.$aluno->matricula.'_'.date('Ydm_His').'.'.$model->file->extension);
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
        if ( (Yii::$app->request->referrer) != '/monitoria/aluno')
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
        if (Yii::$app->user->identity->perfil == 'Aluno') 
        {
            $this->findModel($id)->delete();
            //return $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['aluno']);
        }
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

    public function actionAluno()
    {
        //Seleciona o último período de inscrição
        $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
        $searchModel = new AlunoMonitoriaSearch();
        $dataProvider = $searchModel->searchAluno(Yii::$app->request->queryParams+['AlunoMonitoriaSearch' => ['=', 'periodo' => $periodoInscricao->ano.'/'.$periodoInscricao->periodo]]);

        return $this->render('aluno', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSecretaria()
    {
        //Seleciona o último período de inscrição
        $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
        $searchModel = new AlunoMonitoriaSearch();
        $dataProvider = $searchModel->searchSecretaria(Yii::$app->request->queryParams+['AlunoMonitoriaSearch' => ['=', 'periodo' => $periodoInscricao->ano.'/'.$periodoInscricao->periodo]]);

        return $this->render('secretaria', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfessor()
    {
        //Seleciona o último período de inscrição
        $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
        $searchModel = new ProfessorMonitoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams+['ProfessorMonitoriaSearch' => ['=', 'periodo' => $periodoInscricao->ano.'/'.$periodoInscricao->periodo]]);

        return $this->render('professor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAvaliador()
    {
        //Pega professor baseando-se no CPF do usuário logado
        $professor = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
        $comissao = Comissao::findOne(['idProfessor' => $professor->id]);
        if ($comissao != null && $comissao->idProfessor != null) {

            //Seleciona o último período de inscrição
            $periodoInscricao = PeriodoInscricaoMonitoria::find()->orderBy(['id' => SORT_DESC])->one();
            $searchModel = new AlunoMonitoriaSearch();
            $dataProvider = $searchModel->searchAvaliador(Yii::$app->request
                ->queryParams+['AlunoMonitoriaSearch' => ['=', 'periodo' => $periodoInscricao->ano.'/'.$periodoInscricao->periodo]]);

            return $this->render('avaliador', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionJulgarinscricao($id)
    {
        $model = new Monitoria();
        $modelInfo = new ProfessorMonitoria();

        if ($model->load(Yii::$app->request->post())) 
        {
            $arrayUpdate = ['status' => $model->status];
            Yii::$app->db->createCommand()->update('monitoria', ['status' => $model->status], 'id='.$id)->execute();
            return $this->redirect(['avaliador']);
        }
        else
        {
            $model = $this->findModel($id);
            $modelInfo = AlunoMonitoria::findOne(['id' => $id]);

            return $this->render('_form5', [
                'model' => $model,
                'modelInfo' => $modelInfo,
            ]);
        }
    }

    public function actionFormularioinscricao($id)
    {
        $modelMonitoria = AlunoMonitoria::findOne($id);
        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();

        $cssfile = file_get_contents('../web/css/estilo4.css');
        $mpdf = new mPDF('utf-8', 'A4-P');
        $mpdf->title = '4. Cadastro de monitor';
        $mpdf->WriteHTML($cssfile, 1);

        $mpdf->SetHTMLFooter('<p style="text-align: center;">monitoriaufam@outlook.com</p>');

        // Cabeçalho
        $mpdf->WriteHTML('
            <img src="../web/img/cabecalho3.png" alt="Universidade Federal do Amazonas...." width="950" height="85">

            <p style = "text-align: center;"> <b style = "font-family: Microsoft Sans Serif; font-size: 12px;">
            CADASTRO INDIVIDUAL DE MONITOR  – 04 <br> </b>
            </p>
        ');

        //Dados Curso
        $mpdf->WriteHTML('
            <table id="cabecalho1" align="center" width="50%" height="100%" cellspacing="0" cellpadding="0" style="border: none;">
                <tr>
                    <td style="border: 1px solid black; text-align: center;" width="10%">'.($modelMonitoria->bolsa == '1' ? '<b>X</b>' : '&nbsp;').'</td>
                    <td style="font-family: Microsoft Sans Serif; font-size: 12px; border: 1px solid black;" width="35%">BOLSISTA</td>
                    <td style="border: none;" width="10%"></td>
                    <td style="border: 1px solid black; text-align: center;" width="10%">'.($modelMonitoria->bolsa == '0' ? '<b>X</b>' : '&nbsp;').'</td>
                    <td style="font-family: Microsoft Sans Serif; font-size: 12px; border: 1px solid black;" width="35%">NÃO BOLSISTA</td>
                </tr>
            </table>
            <br>

            <table id="cabecalho2" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="15.5%"><b>DEPARTAMENTO</b></td>
                    <td>Coordenação Acadêmica</td>
                </tr> 
            </table>

            <table id="cabecalho3" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="15.5%"><b>UNIDADE</b></td>
                    <td>Instituto de Computação - IComp</td>
                </tr> 
            </table>

            <table id = "cabecalho4" width="30%" height="100%">
                <tr>
                  <td bgcolor="#e6e6e6" width="48.2%"><b>PERÍODO LETIVO</b></td>
                  <td>'.$modelPeriodo->anoPeriodo.'/'.$modelPeriodo->numPeriodo.' </td> 
                </tr> 
            </table>

            <table id = "cabecalho5" width="93%" height="100%">
                <tr>
                  <td bgcolor="#e6e6e6" width="15.5%"><b>DISCIPLINA</b></td>
                  <td>'.$modelMonitoria->nomeDisciplina.'</td> 
                </tr> 
            </table>
        ');

        //Dados Professor
        $mpdf->WriteHTML('
            <br>
            <table id="professor1" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="11%" style = "text-align: center;"><b>PROFESSOR ORIENTADOR</b></td>
                </tr> 
            </table>

            <table id="professor2" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%"><b>NOME COMPLETO</b> (sem abreviações)</td>
                    <td>'.$modelMonitoria->professor.'</td>
                </tr> 
            </table>

            <table id="professor3" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%"><b>FONES DE CONTATO</b></td>
                    <td>'.$modelMonitoria->telefoneProfessor.'</td>
                </tr> 
            </table>

            <table id="professor4" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%"><b>E - MAIL :</b></td>
                    <td>'.$modelMonitoria->emailProfessor.'</td>
                </tr> 
            </table>
        ');

        //Dados Monitor
        $mpdf->WriteHTML('
            <br>
            <table id="monitor1" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="11%" style = "text-align: center;"><b>MONITOR</b></td>
                </tr> 
            </table>

            <table id="monitor2" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>NOME COMPLETO</b> (sem abreviações)</td>
                    <td width="51%">'.$modelMonitoria->aluno.'</td>
                    <td bgcolor="#e6e6e6" width="17%"><b>Nº DE MATRÍCULA</b></td>
                    <td>'.$modelMonitoria->matricula.'</td>
                </tr> 
            </table>

            <table id="monitor3" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>CURSO</b></td>
                    <td>'.$modelMonitoria->nomeCursoAluno.'</td>
                </tr> 
            </table>

            <table id="monitor4" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>ENDEREÇO COMPLETO</b></td>
                    <td>'.$modelMonitoria->enderecoAluno.'</td>
                </tr> 
            </table>

            <table id="monitor5" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>FONES DE CONTATO</b></td>
                    <td width="29%">'.$modelMonitoria->telefoneAluno.'</td>
                    <td bgcolor="#e6e6e6" width="8%"><b>E-MAIL</b></td>
                    <td>'.$modelMonitoria->emailAluno.'</td>
                </tr> 
            </table>

            <table id="monitor6" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>IDENTIDADE</b></td>
                    <td width="34%">'.$modelMonitoria->RgAluno.'</td>
                    <td bgcolor="#e6e6e6" width="5%"><b>CPF</b></td>
                    <td>'.$modelMonitoria->cpf.'</td>
                </tr> 
            </table>

            <table id="monitor7" width="93%" height="100%">
                <tr>
                    <td bgcolor="#e6e6e6" width="18%" style = "text-align: center;"><b>DADOS BANCÁRIOS (somente p/bolsista) </b></td>
                    <td> Banco: '.$modelMonitoria->banco.' 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Agência: '.$modelMonitoria->agencia.' 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Conta corrente: '.$modelMonitoria->conta.'</td>
                </tr> 
            </table>
            <br>

            <p style = "font-family: Microsoft Sans Serif; font-size: 9px;">
            Declaro para os devidos fins, que: <br>

            a) Sou o (a) TITULAR da CONTA CORRENTE acima descrita:<br>
            b) A conclusão do meu curso de graduacao está prevista para o '.$modelMonitoria->semestreConclusao.'º semestre do ano de '.$modelMonitoria->anoConclusao.';<br>
            c) NÃO exerco outra atividade REMUNERADA através de bolsa nesta universidade;<br>
            d) Obtive aprovacão na disciplina objeto da MONITORIA, com média final ( '.$modelMonitoria->mediaFinal.' );<br>
            e) Disponho de 12 horas semanais para exercer a monitoria;<br>
            f) Tenho conhecimento das normas do Programa de Monitoria;<br>
            g) Responsabilizo-me pelas informacões acima.<br>
            </p>
            
            <br><br>
            <p style = "font-family: Microsoft Sans Serif; font-size: 10px;">
            &nbsp;&nbsp;&nbsp;&nbsp; Em, '.date('d').' / '.date('m').' /'.date('Y').'. &nbsp;&nbsp;&nbsp;&nbsp; Assinatura do monitor: ____________________________________________________________________________________
            </p>

            <br><br><br>            
            <p style = "font-family: Microsoft Sans Serif; font-size: 10px;">
            &nbsp; Manaus, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            _______________________________________________
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            _______________________________________________
            </p>

            <p style = "font-family: Microsoft Sans Serif; font-size: 8px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;
            Assinatura do Professor  Orientador
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;
            Visto do Chefe do Depto (com carimbo).
            </p>

        ');

        $mpdf->Output();
        exit;
    }

    public function actionPlanosemestral()           // Justificativa, campo obrigatório do documento Plano Semestral de Monitoria(1)
    {
        $periodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one(); // Pega o último período registrado
        $searchModel = new DisciplinaMonitoriaSearch();
        $dataProvider = $searchModel->searchByPeriodo($periodo->anoPeriodo, $periodo->numPeriodo);
            $model = PeriodoInscricaoMonitoria::find()
                    ->where(['ano' => $periodo->anoPeriodo, 'periodo' => $periodo->numPeriodo])
                    ->orderBy(['id' => SORT_DESC])
                    ->one(); // Pega o último período de inscrição registrado

        if ($model->load(Yii::$app->request->post()) && $model->save()) return $this->actionGerarplanosemestral($model->id);
        else return $this->render('planosemestral', [
                'searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model,]);
    }

    public function actionGerarplanosemestral($id)
    {
        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $justi = PeriodoInscricaoMonitoria::find()->where(['id' => $id])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();

        if ( $dadosCabecalho != null ) 
        {
            $cssfile = file_get_contents('../web/css/estilo1.css');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->title = '1. Plano Semestral de Monitoria';
            $mpdf->WriteHTML($cssfile, 1);

            $mpdf->SetHTMLHeader('
                <img src="../web/img/cabecalho1.png" alt="Universidade Federal do Amazonas...." width="980" height="100">
                ');

            $mpdf->SetHTMLFooter('<p>
                OBS.: Este plano foi aprovado em reunião departamental na data de '.date('d').' / '.date('m').' /'.date('Y').'.
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Manaus, '.date('d').' / '.date('m').' /'.date('Y').'
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                _______________________________________________
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Chefe do Depto (com carimbo) </p>
                ');

            $mpdf->WriteHTML('
                <br><br><br><br>
                <table id="cabecalho1" width="99%" height="100%">
                    <tr>
                        <td bgcolor="#e6e6e6" width="11%">DEPARTAMENTO</td>
                        <td width="40%">Coordenação Acadêmica</td>
                        <td bgcolor="#e6e6e6" width="10%">UNIDADE</td>
                        <td width="28%">Instituto de Computação - IComp</td>
                    </tr> 
                 </table>

                 <table id = "cabecalho2" width="21%" height="100%">
                    <tr>
                      <td bgcolor="#e6e6e6" width="11%">PERÍODO LETIVO</td>
                      <td width="10px">'.$modelPeriodo->anoPeriodo.'/'.$modelPeriodo->numPeriodo.' </td> 
                    </tr> 
                 </table>
            ');

            // Tabela do meio do documento
            $mpdf->WriteHTML('
                <br>
                <table id="plano_semestral" width="1000px" height="5">
                    <tr>
                        <td bgcolor="#e6e6e6" width="389px" rowspan=2>DISCIPLINAS<br> (código e título, sem abreviações)</td>
                        <td bgcolor="#e6e6e6" width="60px" rowspan=2>QTO</td>
                        <td bgcolor="#e6e6e6" width="60px" rowspan=2>QAT</td>
                        <td bgcolor="#e6e6e6" width="60px" colspan=2>LAB.</td>
                        <td bgcolor="#e6e6e6" width="361px" rowspan=2>PROFESSOR<br>ORIENTADOR</td>
                        <td bgcolor="#e6e6e6" width="70px" colspan=2>VAGAS<br>SOLICITADAS</td>
                    </tr>
                    <tr>
                        <td bgcolor="#e6e6e6" width="3%">SIM</tr>
                        <td bgcolor="#e6e6e6" width="3%">NÃO</tr>
                        <td bgcolor="#e6e6e6" width="3%">B</tr>
                        <td bgcolor="#e6e6e6" width="3%">NB</tr>
                    </tr>
                 </table>
                 ');

            $disciplinas = Disciplina::find()->orderBy(['nomeDisciplina' => SORT_ASC])->all();  
            $contador = 0;
            // O find acima pega todas as disciplinas com nome distinto

            if ( $disciplinas == null ) return $this->render('index'); // Naum ha nenhuma disciplina com o período atual
            else 
            {
                $contador = 0;
                foreach($disciplinas as $disc) 
                {
                    $contTurmas = $vagasOfertadas = $vagasBolsistas = $vagasNaoBolsistas = 0; 
                    // l1t1 significa lab = 1, turma(qtde) = 1
                    $l1 = DisciplinaMonitoria::find()->where(['nomeDisciplina' => $disc->nomeDisciplina])
                                                    ->andWhere(['codDisciplina' => $disc->codDisciplina])
                                                    ->andWhere(['lab' => 1])
                                                    ->all();  
                    $l0 = DisciplinaMonitoria::find()->where(['nomeDisciplina' => $disc->nomeDisciplina])
                                                    ->andWhere(['codDisciplina' => $disc->codDisciplina])
                                                    ->andWhere(['lab' => 0])
                                                    ->all(); 

                    if ( $l1 != null )        // A disciplina em questao tem registro com 'sim' para laboratorio
                    {
                        $contL1 = count($l1);
                        foreach ($l1 as $d1) 
                        {
                            $contTurmas++;
                            $vagasOfertadas = $d1->qtdVagas + $vagasOfertadas;
                            $vagasBolsistas = $d1->qtdMonitorBolsista + $vagasBolsistas;
                            $vagasNaoBolsistas = $d1->qtdMonitorNaoBolsista + $vagasNaoBolsistas;
                        }
                        if ( $contL1 == 1 )   // A disciplina em questao tem somente um registro
                        {
                            foreach ($l1 as $d1) 
                            {
                                $mpdf->WriteHTML('
                                    <table id="plano_semestral" width="1000px" height="5">
                                        <tr>
                                            <td width="387px" rowspan=2 style="max-width: 387px;">'.$d1->codDisciplina.' -<br>'.$d1->nomeDisciplina.'</td>
                                            <td width="60px" rowspan=2>'.$contTurmas.'</td>
                                            <td width="60px" rowspan=2>'.$vagasOfertadas.'</td>
                                            <td width="30px">X</tr>
                                            <td width="30px"></tr>
                                            <td width="361px" rowspan=2>'.$d1->nomeProfessor.'</td>
                                            <td width="34px">'.$vagasBolsistas.'</tr>
                                            <td width="34px">'.$vagasNaoBolsistas.'</tr>
                                        </tr>
                                    </table>
                                '); 
                            }
                            $contador++;
                        }
                        else                 // A disciplina em questao tem mais de um registro
                        {
                            $profsDisc = DisciplinaMonitoria::find()->select('nomeProfessor')
                                                                     ->where(['nomeDisciplina' => $disc->nomeDisciplina])
                                                                     ->andWhere(['codDisciplina' => $disc->codDisciplina])
                                                                     ->andWhere(['lab' => 1])
                                                                     ->distinct()
                                                                     ->asArray()
                                                                     ->all();  
                            
                            $contador = count($prosDisc) + $contador;

                            $profs = $this->convert_array_imploding($profsDisc); 

                            $mpdf->WriteHTML('
                                    <table id="plano_semestral" width="1000px" height="5">
                                        <tr>
                                            <td width="387px" rowspan=2 style="max-width: 387px;">'.$d1->codDisciplina.' -<br>'.$d1->nomeDisciplina.'</td>
                                            <td width="60px" rowspan=2>'.$contTurmas.'</td>
                                            <td width="60px" rowspan=2>'.$vagasOfertadas.'</td>
                                            <td width="30px">X</tr>
                                            <td width="30px"> </tr>
                                            <td width="361px" rowspan=2>'.$profs.'</td>
                                            <td width="34px">'.$vagasBolsistas.'</tr>
                                            <td width="34px">'.$vagasNaoBolsistas.'</tr>
                                        </tr>
                                    </table>
                            '); 
                            
                        }
                        $contTurmas = $vagasOfertadas = $vagasBolsistas = $vagasNaoBolsistas = 0; 
                    }
                    if ( $l0 != null )       // A disciplina em questao tem registro com 'nao' para laboratorio
                    {
                        foreach ($l0 as $d0) 
                        {
                            $contTurmas++;
                            $vagasOfertadas = $d0->qtdVagas + $vagasOfertadas;
                            $vagasBolsistas = $d0->qtdMonitorBolsista + $vagasBolsistas;
                            $vagasNaoBolsistas = $d0->qtdMonitorNaoBolsista + $vagasNaoBolsistas;
                            $contador++;
                        }

                        $contL0 = count($l0);

                        if ( $contL0 == 1 )  // A disciplina em questao tem somente um registro
                        {
                            foreach ($l0 as $d0) {
                                $mpdf->WriteHTML('
                                    <table id="plano_semestral" width="1000px" height="5">
                                        <tr>
                                            <td width="387px" rowspan=2 style="max-width: 387px;">'.$d0->codDisciplina.' -<br>'.$d0->nomeDisciplina.'</td>
                                            <td width="60px" rowspan=2>'.$contTurmas.'</td>
                                            <td width="60px" rowspan=2>'.$vagasOfertadas.'</td>
                                            <td width="30px"> </tr>
                                            <td width="30px">X</tr>
                                            <td width="361px" rowspan=2>'.$d0->nomeProfessor.'</td>
                                            <td width="34px">'.$vagasBolsistas.'</tr>
                                            <td width="34px">'.$vagasNaoBolsistas.'</tr>
                                        </tr>
                                    </table>
                                '); 
                                $contador++;
                            }
                        }
                        else                // A disciplina em questao tem mais de um registro
                        {
                            $profsDisc = DisciplinaMonitoria::find()->select('nomeProfessor')
                                                                     ->where(['nomeDisciplina' => $disc->nomeDisciplina])
                                                                     ->andWhere(['codDisciplina' => $disc->codDisciplina])
                                                                     ->andWhere(['lab' => 0])
                                                                     ->distinct()
                                                                     ->asArray()
                                                                     ->all();
                            $contador = count($prosDisc) + $contador; 

                            $profs = $this->convert_array_imploding($profsDisc); 

                            $mpdf->WriteHTML('
                                    <table id="plano_semestral" width="1000px" height="5">
                                        <tr>
                                            <td width="387px" rowspan=2 style="max-width: 387px;">'.$d0->codDisciplina.' -<br>'.$d0->nomeDisciplina.'</td>
                                            <td width="60px" rowspan=2>'.$contTurmas.'</td>
                                            <td width="60px" rowspan=2>'.$vagasOfertadas.'</td>
                                            <td width="30px"> </tr>
                                            <td width="30px">X</tr>
                                            <td width="361px" rowspan=2>'.$profs.'</td>
                                            <td width="34px">'.$vagasBolsistas.'</tr>
                                            <td width="34px">'.$vagasNaoBolsistas.'</tr>
                                        </tr>
                                    </table>
                            '); 

                        }
                    }
                } # else FOR ( $d == null )  END

            } # foreach($disciplinas as $disc)  END
            
            if ( $contador >= 10 )
            {
                $mpdf->AddPage();
                $mpdf->WriteHTML('<br><br><br><br>');
            }
            $mpdf->WriteHTML('
                <br>
                <p>OBS.: é imprescindível o preenchimento dos campos acima para a análise pela Comissão de Monitoria</p>
                <p>
                LEGENDA: &nbsp;QTO= quantidade de turmas oferecidas no semestre<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                QAT= quantidade de alunos por turma<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                LAB.= existência de laboratório na disciplina<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                B= bolsista<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                NB= não bolsista
                </p>

                <p style="font-family: times; font-size: 12px;">JUSTIFICATIVAS:<br>
                '.$justi->justificativa.'
            ');   

            $mpdf->Output();
            exit;
        }

        else return $this->render('index');
    }

    public function actionGerarquadrogeral()
    {

        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();

        if ( $dadosCabecalho != null ) {

            $cssfile = file_get_contents('../web/css/estilo3.css');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->title = '3. Quadro Geral';
            $mpdf->WriteHTML($cssfile, 1);
            //$mpdf->Image('../web/img/cabecalho.png', 20, 5, 900, 80);

            // Cabeçalho + primeira tabela do documento
            $mpdf->WriteHTML('
                <img src="../web/img/cabecalho3.png" alt="Universidade Federal do Amazonas...." width="950" height="85">

                <p style = "text-align: center;"> <b style = "font-size: small;">
                QUADRO GERAL DE MONITORES BOLSISTAS E NÃO BOLSISTAS - 03 <br> </b>
                (<b style = "background-color: yellow;">Encaminhar também em formato .DOC -word- para o email monitoriaufam@outlook.com</b>)
                </p>

                <table id="cabecalho_1_QuadroGeral" width="99%" height="100%">
                    <tr>
                      <td bgcolor="#e6e6e6"> <b>SETOR RESPONSÁVEL (Coord.Dept/Outros)</b> </td>
                      <td width="30%">Coordenação Acadêmica</td>
                      <td bgcolor="#e6e6e6"><b>UNIDADE</b></td>
                      <td width="30%">Instituto de Computação - IComp</td>
                    </tr> 
                 </table>
                 <table id = "cabecalho_2_QuadroGeral" width="40%" height="100%">
                    <tr>
                      <td bgcolor="#e6e6e6" width="29%"><b>PERÍODO LETIVO</b></td>
                      <td width="20px">'.$modelPeriodo->anoPeriodo.'/'.$modelPeriodo->numPeriodo.' </td> 
                    </tr> 
                 </table>

            ');

            // Tabela do meio do documento
            $mpdf->WriteHTML('
                <br>
                <table id="quadro_geral" width="99%">
                <tr>
                    <td id="n" value="0" bgcolor="#e6e6e6" width="3%" rowspan=2><b>Nº</b></td>
                    <td id="aluno" value="0" bgcolor="#e6e6e6" width="25%" rowspan=2><b>ALUNO</b><br>(nome completo, sem abreviações)</td>
                    <td id="mat" value="0" bgcolor="#e6e6e6" width="6%" rowspan=2><b>Nº <br>MATR.</b></td>
                    <td id="cpf" value="0" bgcolor="#e6e6e6" width="8%" rowspan=2><b>CPF</b></td>
                    <td id="cat" value="0" bgcolor="#e6e6e6" colspan=2 width="6%" colspan=2><b>CATEG.</b></td>
                    <td id="curso" value="0" bgcolor="#e6e6e6" width="13%" rowspan=2><b>CURSO</b></td>
                    <td id="disc" value="0" bgcolor="#e6e6e6" width="14%" rowspan=2><b>DISCIPLINAS</b><br> (código e título, sem abreviações)</td>
                    <td id="prof" value="0" bgcolor="#e6e6e6" width="25%" rowspan=2><b>PROFESSOR ORIENTADOR</b><br> (nome completo, sem abreviações)</td>
                </tr>
                <tr>
                    <td bgcolor="#e6e6e6" width="3%">B</tr>
                    <td bgcolor="#e6e6e6" width="3%">NB</tr>
                </tr>
                 </table>
                 ');

        $aM = AlunoMonitoria::find()->where(['periodo' => $periodoletivo])->andWhere(['status' => 'Deferido'])->orderBy(['aluno' => SORT_DESC])->all();
        $count = count($aM);
        $n = 1;
        $id = 0;

        foreach ($aM as $monitor)        
        {
            $disc = DisciplinaMonitoria::find()->where(['id' => $monitor->id_disciplina])->one();
            $codCurso = Curso::find()->where(['nome' => $monitor->nomeCurso])->one();

            if ( $monitor->bolsa == 0 ) // Row para alunos não-bolsistas
            {
                $mpdf->WriteHTML('
                    <table id="quadro_geral" width="99%">
                        <tr>
                            <td width="3%">'.$n.'</td>
                            <td width="25%">'.$monitor->aluno.'</td>
                            <td width="6%">'.$monitor->matricula.'</td>
                            <td width="8%">'.$monitor->cpf.'</td>
                            <td width="3%"></td>
                            <td width="3%">X</td>
                            <td width="13%">'.$codCurso->codigo.' - '.$monitor->nomeCurso.'</td>
                            <td width="14%">'.$disc->codDisciplina.' - '.$monitor->nomeDisciplina.'</td>
                            <td width="25%">'.$monitor->professor.'</td>
                        </tr>
                         </table>
                ');
            }
            elseif ( $monitor->bolsa == 1 ){  // Row para alunos bolsistas
                $mpdf->WriteHTML('
                    <table id="quadro_geral" width="99%">
                        <tr>
                            <td width="3%">'.$n.'</td>
                            <td width="25%">'.$monitor->aluno.'</td>
                            <td width="6%">'.$monitor->matricula.'</td>
                            <td width="8%">'.$monitor->cpf.'</td>
                            <td width="3%">X</td>
                            <td width="3%"></td>
                            <td width="13%">'.$codCurso->codigo.' - '.$monitor->nomeCurso.'</td>
                            <td width="14%">'.$disc->codDisciplina.' - '.$monitor->nomeDisciplina.'</td>
                            <td width="25%">'.$monitor->professor.'</td>
                        </tr>
                    </table>
                ');
            }

            $count--;
            $n++;
            $id = $monitor->id;
        }

        // Footer do documento
        $mpdf->WriteHTML('

                 <footer> <p>
                    <b>(*)</b> Relacionar todos os monitores de todas as disciplinas do departamento neste mesmo quadro, observando a quantidade total de vagas aprovadas pela Comissão de Monitoria do Programa.<br>
                    <b>(*) B</b> = Bolsista<br>
                    <b>NB</b> = Não Bolsista<br>
                    OBS.: Encaminhar cópia deste quadro à DPA/PROEG para nomeação em portaria. 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Manaus, '.date('d').' / '.date('m').' / '.date('Y').'. 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    _________________________________________________________
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Chefe do Depto (com carimbo).    
                    </p>
                </footer>
                ');


            $mpdf->Output();
            exit;
        }
        else return $this->render('gerarquadrogeral');
    }

    public function actionFrequenciageral()
    {
        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();

        if ( $dadosCabecalho != null ) 
        { 
            $cssfile = file_get_contents('../web/css/estilo6.css');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->title = '6. Frequência Geral';
            $mpdf->WriteHTML($cssfile, 1);
            
            $mes = date('m') - 1;
            $ano = date('Y');
            if ( $mes == 0 ) 
            {
                $mes = 12;
                $ano = $ano - 1;
            }
            $primeiroDia = $ano .'-'.$mes.'-01';
            $ultimoDia = date('Y-m-t', strtotime($primeiroDia));
            $mesNome = Monitoria::nomeMes($mes);

            $mpdf->SetHTMLHeader('
                    <img src="../web/img/cabecalho6.png" alt="Universidade Federal do Amazonas...." width="995" height="88" >
            ');
            $mpdf->SetHTMLFooter('<p style="text-align: center;">monitoriaufam@outlook.com</p>
            ');

            // Cabeçalho + primeira tabela do documento
            $mpdf->WriteHTML('
                    <br><br><br><br>
                    <table id="cabecalho_1_frequenciaGeral" width="99%" height="100%">
                        <tr>
                          <td bgcolor="#e6e6e6">SETOR RESPONSÁVEL (Coord.Dept/Outros)</td>
                          <td width="30%">Coordenação Acadêmica</td>
                          <td bgcolor="#e6e6e6">UNIDADE</td>
                          <td width="30%">Institito de Computação - IComp</td>
                        </tr> 
                     </table>
                     <table id = "cabecalho_3_QuadroGeral" height="100%">
                        <tr>
                            <td bgcolor="#e6e6e6" width="275px">  PERÍODO LETIVO  </td>
                            <td width="124px">'.$periodoletivo.'</td>
                            <td bgcolor="#e6e6e6" width="59px">MÊS</td>
                            <td width="117px">'.$mesNome.'</td>
                        </tr>
                     </table>
            ');

            // Tabela do meio do documento
            $mpdf->WriteHTML('
                <br>
                <table id="frequencia_geral" width="99%">
                    <tr>
                    <td bgcolor="#e6e6e6" width="3%">Nº</td>
                    <td bgcolor="#e6e6e6" width="3%">B</td>
                    <td bgcolor="#e6e6e6" width="3%">NB</td>
                    <td bgcolor="#e6e6e6" width="30%">ALUNOS</td>
                    <td bgcolor="#e6e6e6" width="30%">DISCIPLINAS</td>
                    <td bgcolor="#e6e6e6" width="20%">PROFESSORES ORIENTADORES</td>
                    <td bgcolor="#e6e6e6" width="10%">C.H./MÊS</td>
                    </tr>
                 </table>
                 ');

            $alunos = AlunoMonitoria::find()->where(['periodo' => $periodoletivo])
                                            ->andWhere(['status' => 'Deferido'])
                                            ->orderBy(['aluno' => SORT_ASC])
                                            ->all();
            $totalAlunos = count($alunos);
            $n = 1;
            $marcador = 0;

            foreach ($alunos as $monitor) 
            {
                if ( $n == 13)  // Esses ifs são gambiarras para evitar que as linhas das tabelas passem por cima da imagem do header
                {
                    $mpdf->AddPage();
                    $mpdf->WriteHTML('
                        <br><br><br><br>
                        <table id="frequencia_geral">
                            <tr>
                            <td bgcolor="#e6e6e6" width="31px">Nº</td>
                            <td bgcolor="#e6e6e6" width="31px">B </td>
                            <td bgcolor="#e6e6e6" width="31px">NB</td>
                            <td bgcolor="#e6e6e6" width="300px">ALUNOS</td>
                            <td bgcolor="#e6e6e6" width="300px">DISCIPLINAS</td>
                            <td bgcolor="#e6e6e6" width="204px">PROFESSORES ORIENTADORES</td>
                            <td bgcolor="#e6e6e6" width="101px">C.H./MÊS</td>
                            </tr>
                         </table>
                    ');
                    $marcador = $n;
                }
                elseif ( ($n - $marcador) == 15 )
                {
                    $mpdf->AddPage();
                    $mpdf->WriteHTML('
                        <br><br><br><br>
                        <table id="frequencia_geral">
                            <tr>
                            <td bgcolor="#e6e6e6" width="31px">Nº</td>
                            <td bgcolor="#e6e6e6" width="31px">B</td>
                            <td bgcolor="#e6e6e6" width="31px">NB</td>
                            <td bgcolor="#e6e6e6" width="300px">ALUNOS</td>
                            <td bgcolor="#e6e6e6" width="300px">DISCIPLINAS</td>
                            <td bgcolor="#e6e6e6" width="204px">PROFESSORES ORIENTADORES</td>
                            <td bgcolor="#e6e6e6" width="101px">C.H./MÊS</td>
                            </tr>
                         </table>
                    ');
                    $marcador = $n;
                }

                $disc = DisciplinaMonitoria::find()->where(['id' => $monitor->id_disciplina])->one();

                $freqs = Frequencia::find()->where(['IDMonitoria' => $monitor->id])
                                           ->andWhere(['>=', 'dmy', $primeiroDia])
                                           ->andWhere(['<=', 'dmy', $ultimoDia])
                                           ->all();
                $totalFreqs = count($freqs);

                if ( $totalFreqs >= 1 )
                {
                    $cargaTotal = 0;

                    foreach ($freqs as $f)  // Dá o total de horas que o monitor realizou neste mês
                    {
                        $cargaTotal = $f->ch + $cargaTotal;
                    }

                    if ( $monitor->bolsa == 0 )
                    {
                        $mpdf->WriteHTML('
                            <table id="frequencia_geral">
                                <tr>
                                <td width="31px">'.$n.'</td>
                                <td width="31px"> </td>
                                <td width="31px"> X </td>
                                <td width="300px">'.$monitor->aluno.'</td>
                                <td width="300px">'.$disc->codDisciplina.' - '.$monitor->nomeDisciplina.'</td>
                                <td width="204px">'.$monitor->professor.'</td>
                                <td width="101px">'.$cargaTotal.'h</td>
                                </tr>
                             </table>
                         ');
                    }
                    elseif ( $monitor->bolsa == 1 )
                    {
                        $mpdf->WriteHTML('
                            <table id="frequencia_geral">
                                <tr>
                                <td width="31px">'.$n.'</td>
                                <td width="31px"> X </td>
                                <td width="31px"> </td>
                                <td width="300px">'.$monitor->aluno.'</td>
                                <td width="300px">'.$disc->codDisciplina.' - '.$monitor->nomeDisciplina.'</td>
                                <td width="204px">'.$monitor->professor.'</td>
                                <td width="101px">'.$cargaTotal.'h</td>
                                </tr>
                             </table>
                         ');
                    }
                    $n++;
                }
            }  // foreach end

            $mpdf->WriteHTML('
                <br>
                <table id="assinatura" style="margin-left:40em;">
                    <tr>
                        <td bgcolor="#e6e6e6" text-align:center style="padding:5px 20px 5px;">
                            VISTO DA CHEFIA <br>DO DEPARTAMENTO ACADÊMICO <br> (COM CARIMBO)
                        </td>

                        <td width="64%" height="100"> </td>
                    </tr>
                </table>
                ');
            $mpdf->WriteHTML(' <p style="position: fixed; text-align: left;"> Manaus, '.date('d').' / '.date('m').' / '.date('Y').'.</p> ');

            $mpdf->Output();
            exit;
        }

        else return $this->render('index', ['erro' => 2]);
    }

    public function actionFrequenciaindividual()
    {

        $modelPeriodo = DisciplinaPeriodo::find()->orderBy(['anoPeriodo' => SORT_DESC, 'numPeriodo' => SORT_DESC])->one();
        $periodoletivo = $modelPeriodo->anoPeriodo . '/' . $modelPeriodo->numPeriodo;
        $dadosCabecalho = Periodo::find()->where(['codigo' => $periodoletivo])->one();
        $monitor = Usuario::find()->where(['cpf' => Yii::$app->user->identity->cpf])->one();

        $monitoria = AlunoMonitoria::find()->where(['periodo' => $periodoletivo])
                                           ->andWhere(['IDAluno' => $monitor->id])
                                           ->andWhere(['status' => 'Deferido'])
                                           ->one();

        if ($monitoria == null ) return $this->render('index', ['erro' => 1]);
        else $disc = DisciplinaMonitoria::find()->where(['id' => $monitoria->id_disciplina])->one();

        if ( $dadosCabecalho != null ) 
        { 
            $cssfile = file_get_contents('../web/css/estilo5.css');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->title = '3. Frequência Individual';
            $mpdf->WriteHTML($cssfile, 1);

            // Cabeçalho do doc
            $mpdf->SetHTMLHeader('
                <img src="../web/img/cabecalho5.png" alt="Universidade Federal do Amazonas...." width="980" height="100">
                ');

            $mes = Monitoria::nomeMes(date('m') - 1);
            $ano = date('Y');
            if ( $mes == 0 ) 
            {
                $mes = 12;
                $ano = $ano - 1;
            }
            $mesNome = Monitoria::nomeMes($mes);

            $mpdf->WriteHTML('
                <br><br><br><br>
                <table id="periodoLetivo_mesAno" width="56%">
                    <tr>
                        <td bgcolor="#e6e6e6" width="7%">PERÍODO LETIVO</td>
                        <td width="21%">'.$periodoletivo.'</td>
                        <td bgcolor="#e6e6e6" width="7%">MÊS/ANO</td>
                        <td width="21%">'.$mesNome.'/'.$ano.'</td>
                    </tr>
                </table>
                <br>
                <table id="department_unity" width="99%">
                    <tr>
                        <td bgcolor="#e6e6e6" width="11%">DEPARTAMENTO</td>
                        <td width="40%">Coordenação Acadêmica</td>
                        <td bgcolor="#e6e6e6" width="10%">UNIDADE</td>
                        <td width="28%">Instituto de Computação - IComp</td>
                    </tr>
                </table>
                <br>
                <table id="disc_dados" width="99%">
                    <tr>
                        <td bgcolor="#e6e6e6" width="25%">DISCIPLINA<br>(código e título sem abreviações)</td>
                        <td width="74%">'.$disc->codDisciplina.' - '.$monitoria->nomeDisciplina.'</td>
                    </tr>
                </table>
            ');

            $mpdf->WriteHTML('
                <br>
                <table id="prof_monitor" width="99%">
                    <tr>
                        <td bgcolor="#e6e6e6" width="49%">PROFESSOR ORIENTADOR<br>(nome completo, sem abreviações e assinatura)</td>
                        <td bgcolor="#e6e6e6" width="50%">MONITOR<br>(nome completo, sem abreviações, nº de matrícula e assinatura)</td>
                    </tr>
                    <tr>
                        <td width="49%" align="left">Nome completo: '.$monitoria->professor.'</td>
                        <td width="50%" align="left">Nome completo: '.$monitoria->aluno.'</td>
                    </tr>
                    <tr>
                        <td width="49%" height="50" align="left">Ass:</td>
                        <td width="50%" height="50" align="left">Ass:</td>
                    </tr>
                </table>
                <br>
            ');

            $array_diaSemana = array();
            $array_diaMes = array();
            $array_carga = array();

            $cont_dia = 1;

            $dia = $ano .'-'.$mes.'-01';  // O primeiro dia (data) do mês anterior
            $diaTotal = date('d', strtotime(date('Y-m-t', strtotime($dia))));

            while ($cont_dia <= $diaTotal) 
            {
                $f = Frequencia::find()->where(['dmy' => $dia])
                                           ->andWhere(['>=', 'IDMonitoria', $monitoria->id])
                                           ->one();

                if ( $f != null ) // Dia da frequencia bate com o dia contado
                {
                    $array_carga[] = $f->ch; 
                }
                else  // Dia da frequencia não bate com o dia contado
                {
                    $array_carga[] = '-';
                }

                
                $array_diaSemana[] = Monitoria::nomeDia(date('w', strtotime($dia)));  // Pega tradução do dia da semana e põe no array
                $aux = strtotime("+1 day", strtotime($dia));
                $dia = date('Y-m-d', $aux);
                $array_diaMes[] = $cont_dia;                                // Põe o dia no array

                $cont_dia++;
            }
            //return $this->render('index');

            if ( $diaTotal == 28) {
                $mpdf->WriteHTML('
                    <table id="calendario"  height="25px" width="900px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_da_semana.png" alt="DIA DA SEMANA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaSemana[0].'</td> <td width="30px">'.$array_diaSemana[1].'</td> <td width="30px">'.$array_diaSemana[2].'</td> 
                            <td width="30px">'.$array_diaSemana[3].'</td> <td width="30px">'.$array_diaSemana[4].'</td> <td width="30px">'.$array_diaSemana[5].'</td>
                            <td width="30px">'.$array_diaSemana[6].'</td> <td width="30px">'.$array_diaSemana[7].'</td> <td width="30px">'.$array_diaSemana[8].'</td>
                            <td width="30px">'.$array_diaSemana[9].'</td> <td width="30px">'.$array_diaSemana[10].'</td> <td width="30px">'.$array_diaSemana[11].'</td>
                            <td width="30px">'.$array_diaSemana[12].'</td> <td width="30px">'.$array_diaSemana[13].'</td> <td width="30px">'.$array_diaSemana[14].'</td>
                            <td width="30px">'.$array_diaSemana[15].'</td> <td width="30px">'.$array_diaSemana[16].'</td> <td width="30px">'.$array_diaSemana[17].'</td>
                            <td width="30px">'.$array_diaSemana[18].'</td> <td width="30px">'.$array_diaSemana[19].'</td> <td width="30px">'.$array_diaSemana[20].'</td>
                            <td width="30px">'.$array_diaSemana[21].'</td> <td width="30px">'.$array_diaSemana[22].'</td> <td width="30px">'.$array_diaSemana[23].'</td>
                            <td width="30px">'.$array_diaSemana[24].'</td> <td width="30px">'.$array_diaSemana[25].'</td> <td width="30px">'.$array_diaSemana[26].'</td>
                            <td width="30px">'.$array_diaSemana[27].'</td> <td width="30px">'.$array_diaSemana[28].'</td> <td width="30px">'.$array_diaSemana[29].'</td>
                            <td width="30px">'.$array_diaSemana[30].'</td>
                        </tr>
                    </table>
                ');  

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="902px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_do_mes.png" alt="DIA DO MÊS" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaMes[0].'</td> <td width="30px">'.$array_diaMes[1].'</td> <td width="30px">'.$array_diaMes[2].'</td> 
                            <td width="30px">'.$array_diaMes[3].'</td> <td width="30px">'.$array_diaMes[4].'</td> <td width="30px">'.$array_diaMes[5].'</td>
                            <td width="30px">'.$array_diaMes[6].'</td> <td width="30px">'.$array_diaMes[7].'</td> <td width="30px">'.$array_diaMes[8].'</td>
                            <td width="30px">'.$array_diaMes[9].'</td> <td width="30px">'.$array_diaMes[10].'</td> <td width="30px">'.$array_diaMes[11].'</td>
                            <td width="30px">'.$array_diaMes[12].'</td> <td width="30px">'.$array_diaMes[13].'</td> <td width="30px">'.$array_diaMes[14].'</td>
                            <td width="30px">'.$array_diaMes[15].'</td> <td width="30px">'.$array_diaMes[16].'</td> <td width="30px">'.$array_diaMes[17].'</td>
                            <td width="30px">'.$array_diaMes[18].'</td> <td width="30px">'.$array_diaMes[19].'</td> <td width="30px">'.$array_diaMes[20].'</td>
                            <td width="30px">'.$array_diaMes[21].'</td> <td width="30px">'.$array_diaMes[22].'</td> <td width="30px">'.$array_diaMes[23].'</td>
                            <td width="30px">'.$array_diaMes[24].'</td> <td width="30px">'.$array_diaMes[25].'</td> <td width="30px">'.$array_diaMes[26].'</td>
                            <td width="30px">'.$array_diaMes[27].'</td> <td width="30px">'.$array_diaMes[28].'</td> <td width="30px">'.$array_diaMes[29].'</td>
                            <td width="30px">'.$array_diaMes[30].'</td>
                        </tr>
                    </table>
                ');

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="90px">
                        <tr>
                            <td bgcolor="#e6e6e6">
                            <img src="../web/img/carga_horaria.png" alt="CARGA HORÁRIA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_carga[0].'</td> <td width="30px">'.$array_carga[1].'</td> <td width="30px">'.$array_carga[2].'</td> 
                            <td width="30px">'.$array_carga[3].'</td> <td width="30px">'.$array_carga[4].'</td> <td width="30px">'.$array_carga[5].'</td>
                            <td width="30px">'.$array_carga[6].'</td> <td width="30px">'.$array_carga[7].'</td> <td width="30px">'.$array_carga[8].'</td>
                            <td width="30px">'.$array_carga[9].'</td> <td width="30px">'.$array_carga[10].'</td> <td width="30px">'.$array_carga[11].'</td>
                            <td width="30px">'.$array_carga[12].'</td> <td width="30px">'.$array_carga[13].'</td> <td width="30px">'.$array_carga[14].'</td>
                            <td width="30px">'.$array_carga[15].'</td> <td width="30px">'.$array_carga[16].'</td> <td width="30px">'.$array_carga[17].'</td>
                            <td width="30px">'.$array_carga[18].'</td> <td width="30px">'.$array_carga[19].'</td> <td width="30px">'.$array_carga[20].'</td>
                            <td width="30px">'.$array_carga[21].'</td> <td width="30px">'.$array_carga[22].'</td> <td width="30px">'.$array_carga[23].'</td>
                            <td width="30px">'.$array_carga[24].'</td> <td width="30px">'.$array_carga[25].'</td> <td width="30px">'.$array_carga[26].'</td>
                            <td width="30px">'.$array_carga[27].'</td> <td width="30px"> -- </td> <td width="30px"> -- </td>
                            <td width="30px"> -- </td>
                        </tr>
                    </table>
                ');

            }
            elseif ( $diaTotal == 29 ) {
                $mpdf->WriteHTML('
                    <table id="calendario"  height="25px" width="900px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_da_semana.png" alt="DIA DA SEMANA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaSemana[0].'</td> <td width="30px">'.$array_diaSemana[1].'</td> <td width="30px">'.$array_diaSemana[2].'</td> 
                            <td width="30px">'.$array_diaSemana[3].'</td> <td width="30px">'.$array_diaSemana[4].'</td> <td width="30px">'.$array_diaSemana[5].'</td>
                            <td width="30px">'.$array_diaSemana[6].'</td> <td width="30px">'.$array_diaSemana[7].'</td> <td width="30px">'.$array_diaSemana[8].'</td>
                            <td width="30px">'.$array_diaSemana[9].'</td> <td width="30px">'.$array_diaSemana[10].'</td> <td width="30px">'.$array_diaSemana[11].'</td>
                            <td width="30px">'.$array_diaSemana[12].'</td> <td width="30px">'.$array_diaSemana[13].'</td> <td width="30px">'.$array_diaSemana[14].'</td>
                            <td width="30px">'.$array_diaSemana[15].'</td> <td width="30px">'.$array_diaSemana[16].'</td> <td width="30px">'.$array_diaSemana[17].'</td>
                            <td width="30px">'.$array_diaSemana[18].'</td> <td width="30px">'.$array_diaSemana[19].'</td> <td width="30px">'.$array_diaSemana[20].'</td>
                            <td width="30px">'.$array_diaSemana[21].'</td> <td width="30px">'.$array_diaSemana[22].'</td> <td width="30px">'.$array_diaSemana[23].'</td>
                            <td width="30px">'.$array_diaSemana[24].'</td> <td width="30px">'.$array_diaSemana[25].'</td> <td width="30px">'.$array_diaSemana[26].'</td>
                            <td width="30px">'.$array_diaSemana[27].'</td> <td width="30px">'.$array_diaSemana[28].'</td> <td width="30px">'.$array_diaSemana[29].'</td>
                            <td width="30px">'.$array_diaSemana[30].'</td>
                        </tr>
                    </table>
                ');  

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="902px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_do_mes.png" alt="DIA DO MÊS" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaMes[0].'</td> <td width="30px">'.$array_diaMes[1].'</td> <td width="30px">'.$array_diaMes[2].'</td> 
                            <td width="30px">'.$array_diaMes[3].'</td> <td width="30px">'.$array_diaMes[4].'</td> <td width="30px">'.$array_diaMes[5].'</td>
                            <td width="30px">'.$array_diaMes[6].'</td> <td width="30px">'.$array_diaMes[7].'</td> <td width="30px">'.$array_diaMes[8].'</td>
                            <td width="30px">'.$array_diaMes[9].'</td> <td width="30px">'.$array_diaMes[10].'</td> <td width="30px">'.$array_diaMes[11].'</td>
                            <td width="30px">'.$array_diaMes[12].'</td> <td width="30px">'.$array_diaMes[13].'</td> <td width="30px">'.$array_diaMes[14].'</td>
                            <td width="30px">'.$array_diaMes[15].'</td> <td width="30px">'.$array_diaMes[16].'</td> <td width="30px">'.$array_diaMes[17].'</td>
                            <td width="30px">'.$array_diaMes[18].'</td> <td width="30px">'.$array_diaMes[19].'</td> <td width="30px">'.$array_diaMes[20].'</td>
                            <td width="30px">'.$array_diaMes[21].'</td> <td width="30px">'.$array_diaMes[22].'</td> <td width="30px">'.$array_diaMes[23].'</td>
                            <td width="30px">'.$array_diaMes[24].'</td> <td width="30px">'.$array_diaMes[25].'</td> <td width="30px">'.$array_diaMes[26].'</td>
                            <td width="30px">'.$array_diaMes[27].'</td> <td width="30px">'.$array_diaMes[28].'</td> <td width="30px">'.$array_diaMes[29].'</td>
                            <td width="30px">'.$array_diaMes[30].'</td>
                        </tr>
                    </table>
                ');

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="90px">
                        <tr>
                            <td bgcolor="#e6e6e6">
                            <img src="../web/img/carga_horaria.png" alt="CARGA HORÁRIA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_carga[0].'</td> <td width="30px">'.$array_carga[1].'</td> <td width="30px">'.$array_carga[2].'</td> 
                            <td width="30px">'.$array_carga[3].'</td> <td width="30px">'.$array_carga[4].'</td> <td width="30px">'.$array_carga[5].'</td>
                            <td width="30px">'.$array_carga[6].'</td> <td width="30px">'.$array_carga[7].'</td> <td width="30px">'.$array_carga[8].'</td>
                            <td width="30px">'.$array_carga[9].'</td> <td width="30px">'.$array_carga[10].'</td> <td width="30px">'.$array_carga[11].'</td>
                            <td width="30px">'.$array_carga[12].'</td> <td width="30px">'.$array_carga[13].'</td> <td width="30px">'.$array_carga[14].'</td>
                            <td width="30px">'.$array_carga[15].'</td> <td width="30px">'.$array_carga[16].'</td> <td width="30px">'.$array_carga[17].'</td>
                            <td width="30px">'.$array_carga[18].'</td> <td width="30px">'.$array_carga[19].'</td> <td width="30px">'.$array_carga[20].'</td>
                            <td width="30px">'.$array_carga[21].'</td> <td width="30px">'.$array_carga[22].'</td> <td width="30px">'.$array_carga[23].'</td>
                            <td width="30px">'.$array_carga[24].'</td> <td width="30px">'.$array_carga[25].'</td> <td width="30px">'.$array_carga[26].'</td>
                            <td width="30px">'.$array_carga[27].'</td> <td width="30px">'.$array_carga[28].'</td> <td width="30px"> -- </td>
                            <td width="30px"> -- </td>
                        </tr>
                    </table>
                ');

            }
            elseif ( $diaTotal == 30 ) {
                $mpdf->WriteHTML('
                    <table id="calendario"  height="25px" width="900px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_da_semana.png" alt="DIA DA SEMANA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaSemana[0].'</td> <td width="30px">'.$array_diaSemana[1].'</td> <td width="30px">'.$array_diaSemana[2].'</td> 
                            <td width="30px">'.$array_diaSemana[3].'</td> <td width="30px">'.$array_diaSemana[4].'</td> <td width="30px">'.$array_diaSemana[5].'</td>
                            <td width="30px">'.$array_diaSemana[6].'</td> <td width="30px">'.$array_diaSemana[7].'</td> <td width="30px">'.$array_diaSemana[8].'</td>
                            <td width="30px">'.$array_diaSemana[9].'</td> <td width="30px">'.$array_diaSemana[10].'</td> <td width="30px">'.$array_diaSemana[11].'</td>
                            <td width="30px">'.$array_diaSemana[12].'</td> <td width="30px">'.$array_diaSemana[13].'</td> <td width="30px">'.$array_diaSemana[14].'</td>
                            <td width="30px">'.$array_diaSemana[15].'</td> <td width="30px">'.$array_diaSemana[16].'</td> <td width="30px">'.$array_diaSemana[17].'</td>
                            <td width="30px">'.$array_diaSemana[18].'</td> <td width="30px">'.$array_diaSemana[19].'</td> <td width="30px">'.$array_diaSemana[20].'</td>
                            <td width="30px">'.$array_diaSemana[21].'</td> <td width="30px">'.$array_diaSemana[22].'</td> <td width="30px">'.$array_diaSemana[23].'</td>
                            <td width="30px">'.$array_diaSemana[24].'</td> <td width="30px">'.$array_diaSemana[25].'</td> <td width="30px">'.$array_diaSemana[26].'</td>
                            <td width="30px">'.$array_diaSemana[27].'</td> <td width="30px">'.$array_diaSemana[28].'</td> <td width="30px">'.$array_diaSemana[29].'</td>
                            <td width="30px">'.$array_diaSemana[30].'</td>
                        </tr>
                    </table>
                ');  

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="902px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_do_mes.png" alt="DIA DO MÊS" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaMes[0].'</td> <td width="30px">'.$array_diaMes[1].'</td> <td width="30px">'.$array_diaMes[2].'</td> 
                            <td width="30px">'.$array_diaMes[3].'</td> <td width="30px">'.$array_diaMes[4].'</td> <td width="30px">'.$array_diaMes[5].'</td>
                            <td width="30px">'.$array_diaMes[6].'</td> <td width="30px">'.$array_diaMes[7].'</td> <td width="30px">'.$array_diaMes[8].'</td>
                            <td width="30px">'.$array_diaMes[9].'</td> <td width="30px">'.$array_diaMes[10].'</td> <td width="30px">'.$array_diaMes[11].'</td>
                            <td width="30px">'.$array_diaMes[12].'</td> <td width="30px">'.$array_diaMes[13].'</td> <td width="30px">'.$array_diaMes[14].'</td>
                            <td width="30px">'.$array_diaMes[15].'</td> <td width="30px">'.$array_diaMes[16].'</td> <td width="30px">'.$array_diaMes[17].'</td>
                            <td width="30px">'.$array_diaMes[18].'</td> <td width="30px">'.$array_diaMes[19].'</td> <td width="30px">'.$array_diaMes[20].'</td>
                            <td width="30px">'.$array_diaMes[21].'</td> <td width="30px">'.$array_diaMes[22].'</td> <td width="30px">'.$array_diaMes[23].'</td>
                            <td width="30px">'.$array_diaMes[24].'</td> <td width="30px">'.$array_diaMes[25].'</td> <td width="30px">'.$array_diaMes[26].'</td>
                            <td width="30px">'.$array_diaMes[27].'</td> <td width="30px">'.$array_diaMes[28].'</td> <td width="30px">'.$array_diaMes[29].'</td>
                            <td width="30px">'.$array_diaMes[30].'</td>
                        </tr>
                    </table>
                ');

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="90px">
                        <tr>
                            <td bgcolor="#e6e6e6">
                            <img src="../web/img/carga_horaria.png" alt="CARGA HORÁRIA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_carga[0].'</td> <td width="30px">'.$array_carga[1].'</td> <td width="30px">'.$array_carga[2].'</td> 
                            <td width="30px">'.$array_carga[3].'</td> <td width="30px">'.$array_carga[4].'</td> <td width="30px">'.$array_carga[5].'</td>
                            <td width="30px">'.$array_carga[6].'</td> <td width="30px">'.$array_carga[7].'</td> <td width="30px">'.$array_carga[8].'</td>
                            <td width="30px">'.$array_carga[9].'</td> <td width="30px">'.$array_carga[10].'</td> <td width="30px">'.$array_carga[11].'</td>
                            <td width="30px">'.$array_carga[12].'</td> <td width="30px">'.$array_carga[13].'</td> <td width="30px">'.$array_carga[14].'</td>
                            <td width="30px">'.$array_carga[15].'</td> <td width="30px">'.$array_carga[16].'</td> <td width="30px">'.$array_carga[17].'</td>
                            <td width="30px">'.$array_carga[18].'</td> <td width="30px">'.$array_carga[19].'</td> <td width="30px">'.$array_carga[20].'</td>
                            <td width="30px">'.$array_carga[21].'</td> <td width="30px">'.$array_carga[22].'</td> <td width="30px">'.$array_carga[23].'</td>
                            <td width="30px">'.$array_carga[24].'</td> <td width="30px">'.$array_carga[25].'</td> <td width="30px">'.$array_carga[26].'</td>
                            <td width="30px">'.$array_carga[27].'</td> <td width="30px">'.$array_carga[28].'</td> <td width="30px">'.$array_carga[29].'</td>
                            <td width="30px"> -- </td>
                        </tr>
                    </table>
                ');

            }
            elseif ( $diaTotal == 31 ) {
                $mpdf->WriteHTML('
                    <table id="calendario"  height="25px" width="900px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_da_semana.png" alt="DIA DA SEMANA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaSemana[0].'</td> <td width="30px">'.$array_diaSemana[1].'</td> <td width="30px">'.$array_diaSemana[2].'</td> 
                            <td width="30px">'.$array_diaSemana[3].'</td> <td width="30px">'.$array_diaSemana[4].'</td> <td width="30px">'.$array_diaSemana[5].'</td>
                            <td width="30px">'.$array_diaSemana[6].'</td> <td width="30px">'.$array_diaSemana[7].'</td> <td width="30px">'.$array_diaSemana[8].'</td>
                            <td width="30px">'.$array_diaSemana[9].'</td> <td width="30px">'.$array_diaSemana[10].'</td> <td width="30px">'.$array_diaSemana[11].'</td>
                            <td width="30px">'.$array_diaSemana[12].'</td> <td width="30px">'.$array_diaSemana[13].'</td> <td width="30px">'.$array_diaSemana[14].'</td>
                            <td width="30px">'.$array_diaSemana[15].'</td> <td width="30px">'.$array_diaSemana[16].'</td> <td width="30px">'.$array_diaSemana[17].'</td>
                            <td width="30px">'.$array_diaSemana[18].'</td> <td width="30px">'.$array_diaSemana[19].'</td> <td width="30px">'.$array_diaSemana[20].'</td>
                            <td width="30px">'.$array_diaSemana[21].'</td> <td width="30px">'.$array_diaSemana[22].'</td> <td width="30px">'.$array_diaSemana[23].'</td>
                            <td width="30px">'.$array_diaSemana[24].'</td> <td width="30px">'.$array_diaSemana[25].'</td> <td width="30px">'.$array_diaSemana[26].'</td>
                            <td width="30px">'.$array_diaSemana[27].'</td> <td width="30px">'.$array_diaSemana[28].'</td> <td width="30px">'.$array_diaSemana[29].'</td>
                            <td width="30px">'.$array_diaSemana[30].'</td>
                        </tr>
                    </table>
                ');  

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="902px">
                        <tr>
                            <td bgcolor="#e6e6e6" >
                            <img src="../web/img/dia_do_mes.png" alt="DIA DO MÊS" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_diaMes[0].'</td> <td width="30px">'.$array_diaMes[1].'</td> <td width="30px">'.$array_diaMes[2].'</td> 
                            <td width="30px">'.$array_diaMes[3].'</td> <td width="30px">'.$array_diaMes[4].'</td> <td width="30px">'.$array_diaMes[5].'</td>
                            <td width="30px">'.$array_diaMes[6].'</td> <td width="30px">'.$array_diaMes[7].'</td> <td width="30px">'.$array_diaMes[8].'</td>
                            <td width="30px">'.$array_diaMes[9].'</td> <td width="30px">'.$array_diaMes[10].'</td> <td width="30px">'.$array_diaMes[11].'</td>
                            <td width="30px">'.$array_diaMes[12].'</td> <td width="30px">'.$array_diaMes[13].'</td> <td width="30px">'.$array_diaMes[14].'</td>
                            <td width="30px">'.$array_diaMes[15].'</td> <td width="30px">'.$array_diaMes[16].'</td> <td width="30px">'.$array_diaMes[17].'</td>
                            <td width="30px">'.$array_diaMes[18].'</td> <td width="30px">'.$array_diaMes[19].'</td> <td width="30px">'.$array_diaMes[20].'</td>
                            <td width="30px">'.$array_diaMes[21].'</td> <td width="30px">'.$array_diaMes[22].'</td> <td width="30px">'.$array_diaMes[23].'</td>
                            <td width="30px">'.$array_diaMes[24].'</td> <td width="30px">'.$array_diaMes[25].'</td> <td width="30px">'.$array_diaMes[26].'</td>
                            <td width="30px">'.$array_diaMes[27].'</td> <td width="30px">'.$array_diaMes[28].'</td> <td width="30px">'.$array_diaMes[29].'</td>
                            <td width="30px">'.$array_diaMes[30].'</td>
                        </tr>
                    </table>
                ');

                $mpdf->WriteHTML('
                    <table id="calendario" height="25px" width="90px">
                        <tr>
                            <td bgcolor="#e6e6e6">
                            <img src="../web/img/carga_horaria.png" alt="CARGA HORÁRIA" width="42px" height="50px">
                            </td>
                            <td width="30px">'.$array_carga[0].'</td> <td width="30px">'.$array_carga[1].'</td> <td width="30px">'.$array_carga[2].'</td> 
                            <td width="30px">'.$array_carga[3].'</td> <td width="30px">'.$array_carga[4].'</td> <td width="30px">'.$array_carga[5].'</td>
                            <td width="30px">'.$array_carga[6].'</td> <td width="30px">'.$array_carga[7].'</td> <td width="30px">'.$array_carga[8].'</td>
                            <td width="30px">'.$array_carga[9].'</td> <td width="30px">'.$array_carga[10].'</td> <td width="30px">'.$array_carga[11].'</td>
                            <td width="30px">'.$array_carga[12].'</td> <td width="30px">'.$array_carga[13].'</td> <td width="30px">'.$array_carga[14].'</td>
                            <td width="30px">'.$array_carga[15].'</td> <td width="30px">'.$array_carga[16].'</td> <td width="30px">'.$array_carga[17].'</td>
                            <td width="30px">'.$array_carga[18].'</td> <td width="30px">'.$array_carga[19].'</td> <td width="30px">'.$array_carga[20].'</td>
                            <td width="30px">'.$array_carga[21].'</td> <td width="30px">'.$array_carga[22].'</td> <td width="30px">'.$array_carga[23].'</td>
                            <td width="30px">'.$array_carga[24].'</td> <td width="30px">'.$array_carga[25].'</td> <td width="30px">'.$array_carga[26].'</td>
                            <td width="30px">'.$array_carga[27].'</td> <td width="30px">'.$array_carga[28].'</td> <td width="30px">'.$array_carga[29].'</td>
                            <td width="30px">'.$array_carga[30].'</td>
                        </tr>
                    </table>
                ');

            } 

            $mpdf->WriteHTML('
                <br>
                <table id="assinatura" style="margin-left:30em;">
                    <tr>
                        <td bgcolor="#e6e6e6" text-align:center>
                            VISTO DA CHEFIA <br>DO DEPARTAMENTO ACADÊMICO <br> (COM CARIMBO)
                        </td>

                        <td width="70%" height="100"> </td>
                    </tr>
                </table>');

            $mpdf->Output();
            exit;
        }
        else return $this->render('index', ['erro' => 2]);
    }    

    public function actionGerarplanosemestraldisciplina($id)
    {
        $model = new Monitoria();
        $modelInfo = new ProfessorMonitoria();

        if ($model->load(Yii::$app->request->post())) 
        {
            //Usuario - Pega professor baseando-se no CPF do usuário logado
            $professor = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);

            //Habilitar "extension=php_fileinfo.dll" em C:\xampp\php\php.ini
            $model->filePlanoDisciplina = UploadedFile::getInstance($model, 'filePlanoDisciplina');

            $arrayUpdate = ['pathArqPlanoDisciplina' => 'uploads/plano-semestral-disciplina/'.$professor->cpf.'_'.date('Ydm_His').'.'.$model->filePlanoDisciplina->extension];
            Yii::$app->db->createCommand()->update('monitoria', $arrayUpdate, 'id='.$id)->execute();

            $model->filePlanoDisciplina->saveAs('uploads/plano-semestral-disciplina/'.$professor->cpf.'_'.date('Ydm_His').'.'.$model->filePlanoDisciplina->extension);
            return $this->redirect(['professor']);
        }
        else
        {
            $model = $this->findModel($id);
            $modelInfo = ProfessorMonitoria::findOne(['id' => $id]);

            return $this->render('_form3', [
                'model' => $model,
                'modelInfo' => $modelInfo,
            ]);
        }
    }

    public function actionGerarrelatoriosemestral($id)
    {
        $model = new Monitoria();
        $modelInfo = new ProfessorMonitoria();

        if ($model->load(Yii::$app->request->post())) 
        {
            //Usuario - Pega professor baseando-se no CPF do usuário logado
            $professor = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
            
            //Habilitar "extension=php_fileinfo.dll" em C:\xampp\php\php.ini
            $model->fileRelatorioSemestral = UploadedFile::getInstance($model, 'fileRelatorioSemestral');

            $arrayUpdate = ['pathArqRelatorioSemestral' => 'uploads/relatorio-semestral/'.$professor->cpf.'_'.date('Ydm_His').'.'.$model->fileRelatorioSemestral->extension];
            Yii::$app->db->createCommand()->update('monitoria', $arrayUpdate, 'id='.$id)->execute();

            $model->fileRelatorioSemestral->saveAs('uploads/relatorio-semestral/'.$professor->cpf.'_'.date('Ydm_His').'.'.$model->fileRelatorioSemestral->extension);
            return $this->redirect(['professor']);
        }
        else
        {
            $model = $this->findModel($id);
            $modelInfo = ProfessorMonitoria::findOne(['id' => $id]);

            return $this->render('_form4', [
                'model' => $model,
                'modelInfo' => $modelInfo,
            ]);
        }
    }

    public function convert_multi_array($array) {
      $out = implode("&",array_map(function($a) {return implode("~",$a);},$array));
      return $out;
    }

    public function convert_array_imploding($array) {
      $out = implode(",<br>",array_map(function($a) {return implode("~",$a);},$array));
      return $out;
    }
}
