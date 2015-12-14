<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */
/* @var string $etapa */
/* @var string $erroFatal */
/* @var array[] $erros */

$this->title = 'Importar Disciplinas - Arquivo CSV';
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas do Período', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formimportarcsv', [
    		'model' => $model, 
    		'etapa' => $etapa,
    		'erroFatal' => $erroFatal,
    		'erros' => $erros
    	]) ?>

</div>
