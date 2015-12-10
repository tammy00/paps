<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoInscricaoMonitoria */

$this->title = 'Atualizar ' . $model->id . 'º Período';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['/monitoria/index']];
$this->params['breadcrumbs'][] = ['label' => 'Períodos de Inscrição', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id . 'º', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="periodo-inscricao-monitoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
