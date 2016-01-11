<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Monitoria */
/* @var string $etapa */
/* @var string $periodo */
/* @var string $matricula */
/* @var $searchModel app\models\DisciplinaMonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscrição para Monitoria';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($etapa == '1') { ?>
    <?= $this->render('_form', [
        'model' => $model,
        'etapa' => $etapa,
        'periodo' => $periodo,
        'matricula' => $matricula,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
    <?php } ?>

    <?php if ($etapa == '2') { ?>
    <?= $this->render('_form2', [
        'model' => $model,
        'etapa' => $etapa,
        'periodo' => $periodo,
        'matricula' => $matricula,
    ]) ?>
    <?php } ?>
    
</div>
