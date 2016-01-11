<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoMonitoria */

$this->title = 'Monitoria: '.$model->nomeDisciplina;
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="monitoria-view">

    <h4><?= Html::encode($this->title) ?></h4>
    </br>
    <?php if(Yii::$app->user->identity->perfil === 'Secretaria') { ?>
        <p>
        <?= Html::a('Deferir', ['deferir', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Você realmente deseja deferir esta inscrição?',
                'method' => 'post',
            ],
        ]); ?>
        <?= Html::a('Indeferir', ['indeferir', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Você realmente deseja indeferir esta inscrição?',
                'method' => 'post',
            ],
        ]); ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você realmente deseja deletar este item?',
                'method' => 'post',
            ],
        ]); ?>
        </p>
        <p>
        <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        </p>
    <?php } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Aluno') { ?>
        <p>
        <?php if($model->status == 'Deferido') { ?>
            <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?= Html::a('Frequências', ['/frequencia/index', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php } else { ?>
            <?= Html::a('Formulário de Inscrição', ['formularioinscricao', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Você realmente deseja deletar este item?',
                    'method' => 'post',
                ],
            ]); ?>
        </p>
    <?php } } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'nomeDisciplina',
            'professor',
            'periodo',
            'codTurma',
            'nomeCurso',
            'bolsa_traducao',
            [
                'label' => 'Histórico Escolar',
                'format'=> 'raw',
                'value' => Html::a('Visualizar', '/paps/web/'.$model->pathArqHistorico, ['target'=>'_blank'])
            ],
            'status'
        ],
        'options' => [
            'class' => 'table table-striped table-bordered detail-view',
            'style' => 'width:50%'
        ],
    ]) ?>

    <?php if(Yii::$app->user->identity->perfil === 'Secretaria') { ?>
        <a href="?r=monitoria/secretaria" class="btn btn-default">Voltar</a>
    <?php } ?>

    <?php if(Yii::$app->user->identity->perfil === 'Aluno') { ?>
        <a href="?r=monitoria/aluno" class="btn btn-default">Voltar</a>
    <?php } ?>

</div>
