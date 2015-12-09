<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Frequencia */

$this->title = 'Cadastrar Frequência';
$this->params['breadcrumbs'][] = ['label' => 'Frequencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequencia-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
