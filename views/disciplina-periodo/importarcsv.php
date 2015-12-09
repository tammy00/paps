<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Importar Disciplinas - Arquivo CSV';
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas do Período', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formimportarcsv', ['model' => $model]) ?>

</div>
