<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var array $events */
/* @var string erro */

$this->title = 'Minhas Frequências';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequencia-index">

    <?php if ($erro == '0') { ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Ver todas', ['minhasfrequencias'], ['class' => 'btn btn-success']) ?> 
    </p>

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
    <br>
    
    <?php } else { ?>

        <div class="alert alert-warning">
            <strong>Atenção!</strong> Você não está inscrito em monitorias no período atual.
        </div>

    <?php } ?>

    <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>

</div>
