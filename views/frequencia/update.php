<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Frequencia */

$this->title = 'Atualização de frequência';
//$this->params['breadcrumbs'][] = ['label' => 'Frequências', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->dmy, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="frequencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
