<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FrequenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Minhas Frequências';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Html::a('Ver todas', ['minhasfrequencias'], ['class' => 'btn btn-success']) ?> </p>

    <?php 
    	Modal::begin([
    		'header' => '<h3>Frequência Individual</h3>',
    		'id' => 'modal',
    		'size' => '',
    	]);
    	echo "<div id='modalContent'></div>";
    	Modal::end();
    ?>

  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  )); ?>
</div>
