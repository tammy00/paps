<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comissao */

$this->title = 'Avaliador';
$this->params['breadcrumbs'][] = ['label' => 'Comissão Avaliadora', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comissao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você realmente deseja deletar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'idProfessor',
            'usuario.name',
        ],
    ]) ?>

    <a href="?r=comissao/index" class="btn btn-default">Comissão Avaliadora</a>

</div>
