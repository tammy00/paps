<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comissao */

$this->title = 'Alterar Avaliador';
$this->params['breadcrumbs'][] = ['label' => 'Comissão Avaliadora', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comissao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
