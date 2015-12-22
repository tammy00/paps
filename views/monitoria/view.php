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
    <p>
        <?php if(Yii::$app->user->identity->perfil === 'Secretaria') { ?>
            <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);  ?>
            <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Você realmente deseja deletar este item?',
                    'method' => 'post',
                ],
            ]); ?>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil === 'Aluno' && $model->status == 'Deferido') { ?>
            <?= Html::a('Frequência Individual', ['/frequencia/index', 'id' => $model->id], ['class' => 'btn btn-primary']);  ?>
        <?php } ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'nomeDisciplina',
            'professor',
            'periodo',
            'codTurma',
            'nomeCurso',
            'bolsa_traducao',
            'status'
        ],
        'options' => [
            'class' => 'table table-striped table-bordered detail-view',
            'style' => 'width:50%'
        ],
    ]) ?>

    <a href="?r=monitoria/inscricaoaluno" class="btn btn-default">Voltar</a>

</div>
