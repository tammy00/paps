<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Monitoria */
/* @var string $etapa */
/* @var string $numperiodo */
/* @var string $anoperiodo */
/* @var string $matricula */
/* @var string $banco */
/* @var string $agencia */
/* @var string $conta */

$this->title = 'Alterar Inscrição: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="monitoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render($etapa == '1' ? '_form' : '_form2', [
        'model' => $model,
        'etapa' => $etapa,
        'numperiodo' => $numperiodo,
        'anoperiodo' => $anoperiodo,
        'matricula' => $matricula,
        'banco' => $banco,
        'agencia' => $agencia,
        'conta' => $conta,
    ]) ?>

</div>
