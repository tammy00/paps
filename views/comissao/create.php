<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comissao */

$this->title = 'Criar Avaliador';
$this->params['breadcrumbs'][] = ['label' => 'Comissão Avaliadora', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comissao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
