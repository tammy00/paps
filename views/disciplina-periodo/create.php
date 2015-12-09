<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\DisciplinaSearch;
use app\models\CursoSearch;
use app\models\ProfessorSearch;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */

$this->title = 'Criar Disciplina do Período';
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas do Período', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
