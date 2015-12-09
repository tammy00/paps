<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */

$this->title = 'Alterar Disciplina: ' . ' ' . $model->codDisciplina;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas UFAM', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codDisciplina, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disciplina-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
