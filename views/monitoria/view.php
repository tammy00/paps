<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoMonitoria */

$this->title = $model->codDisciplina.' - '.$model->nomeDisciplina;
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="monitoria-view">

    <h4><?= Html::encode($this->title) ?></h4>
    </br>
    <?php if(Yii::$app->user->identity->perfil === 'Secretaria') { ?>
        <p>
        <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['target'=>'_blank', 'class' => 'btn btn-primary']); ?>

        <?php if (!empty($model->pathArqPlanoDisciplina)) { ?>
            <?= Html::a('Plano Semestral da Disciplina', Url::base().'/'.$model->pathArqPlanoDisciplina, 
                [
                    'target'=>'_blank', 
                    'class'=>'btn btn-primary', 
                ]) ?>
        <?php } else { ?>
            <?= Html::a('Plano Semestral da Disciplina', '', ['class'=>'btn btn-primary', 'disabled' => true]) ?>
        <?php } ?>

        <?php if (!empty($model->pathArqRelatorioSemestral)) { ?>
            <?= Html::a('Relatório Semestral de Monitoria', Url::base().'/'.$model->pathArqRelatorioSemestral, 
                [
                    'target'=>'_blank', 
                    'class'=>'btn btn-primary', 
                ]) ?>
        <?php } else { ?>
            <?= Html::a('Relatório Semestral de Monitoria', '', ['class'=>'btn btn-primary', 'disabled' => true]) ?>
        <?php } ?>

        </p>
    <?php } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Aluno') { ?>
        <p>
        <?php if($model->status == 'Deferido') { ?>
            <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['target'=>'_blank', 'class' => 'btn btn-primary']); ?>
            <?= Html::a('Frequências', ['/frequencia/index', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php } else { ?>
            <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['target'=>'_blank', 'class' => 'btn btn-primary']); ?>
            <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Você realmente deseja deletar este item?',
                    'method' => 'post',
                ],
            ]); ?>
        </p>
    <?php } } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Professor') { ?>
        <p>
        <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['target'=>'_blank', 'class' => 'btn btn-primary']); ?>
        
        <?= Html::a('Julgar', ['julgarinscricao', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>

        </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'aluno',
            'nomeDisciplina',
            'codDisciplina',
            'professor',
            'periodo',
            'codTurma',
            [
                'label' => 'Curso da Disciplina',
                'value' => $model->nomeCurso
            ],
            [
                'label' => 'Curso do Aluno',
                'value' => $model->nomeCursoAluno
            ],
            'bolsa_traducao',
            [
                'label' => 'Histórico Escolar',
                'format'=> 'raw',
                'value' => Html::a('Visualizar', Url::base().'/'.$model->pathArqHistorico, ['target'=>'_blank'])
            ],
            'status'
        ],
        'options' => [
            'class' => 'table table-striped table-bordered detail-view',
            'style' => 'width:50%'
        ],
    ]) ?>

    <?php if(Yii::$app->user->identity->perfil === 'Secretaria') { ?>
        <a href="?r=monitoria/secretaria" class="btn btn-default">Gerenciar Monitorias</a>
    <?php } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Aluno') { ?>
        <a href="?r=monitoria/aluno" class="btn btn-default">Gerenciar Monitorias</a>
    <?php } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Professor') { ?>
        <a href="?r=monitoria/avaliador" class="btn btn-default">Julgar Inscrições</a>
    <?php } ?>

</div>
