<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\DisciplinaSearch;
use app\models\CursoSearch;
use app\models\UsuarioSearch;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */

$this->title = 'Criar Disciplina para Monitoria';
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas para Monitoria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
