<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;
use app\models\DisciplinaMonitoria;
use kartik\select2\Select2;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Monitoria */
/* @var $form yii\widgets\ActiveForm */
/* @var string $etapa */
/* @var string $periodo */
/* @var string $matricula */
/* @var $searchModel app\models\DisciplinaMonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        //[
        //    'label' => 'Etapa',
        //    'value' => $etapa . '/2'
        //],
        [
            'label' => 'Aluno',
            'value' => Yii::$app->user->identity->name
        ],
        [
            'label' => 'Matrícula',
            'value' => $matricula
        ],
        [
            'label' => 'Período',
            'value' => $periodo
        ]
    ],
    'options' => [
        'class' => 'table table-striped table-bordered detail-view',
        'style' => 'width:600px'
    ],
]) ?>

<h4><?= Html::encode('Selecione a Disciplina') ?></h4>

<div>
    <?= GridView::widget([
        'id' => 'kvgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'containerOptions'=>['style'=>'overflow: auto'],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'bordered'=> true,
        'condensed' => true,
        'hover' => true,
        'panel'=>[
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>', //$heading
            'footer' => false,
        ],
        'export'=> false,
        'columns' => [
            [
                'class' => 'kartik\grid\RadioColumn',
                'clearOptions' => ['class'=>'close', 'title'=>'Limpar Seleção'],
                'width'=>'36px',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'radioOptions' => function($model, $key, $index, $column) { return ['value' => $model->id]; }

            ],
            [
                'attribute'=>'nomeDisciplina', 
                'vAlign'=>'middle',
                //'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return Html::a($model->nomeDisciplina,  
                        '#');
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(DisciplinaMonitoria::find()->where(['numPeriodo' => $searchModel->numPeriodo, 'anoPeriodo' => $searchModel->anoPeriodo])->orderBy('nomeDisciplina')->asArray()->all(), 'nomeDisciplina', 'nomeDisciplina'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Disciplina'],
                'format'=>'raw'
            ],
            //'nomeDisciplina',
            'nomeCurso',
            'nomeProfessor',
            'codTurma',
        ],
    ]); ?>

</div>

<div class="monitoria-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'IDDisc')->hiddenInput()->label(false) ?>
        <?= Html::hiddenInput('step', $etapa) ?>

        <div class="form-group">
            <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>
            <?= Html::submitButton('Continuar', ['class' => 'btn btn-success', 'id' => 'btnsubmit']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    //echo Yii::$app->homeUrl;
    //echo Url::base();
    //$this->registerJs('$("document").ready(function(){alert("Ola");});');
    //$this->registerJs('$("#kvgrid").on("grid.radiochecked", function(ev, key, val) { $("#id").val(val); alert("id: " + $("#id").val()); });');
    $this->registerJs('$("document").ready(function() { $("#btnsubmit").prop("disabled", true); });');
    $this->registerJs('$("#kvgrid").on("grid.radiochecked", function(ev, key, val) { $("#monitoria-iddisc").val(val); $("#btnsubmit").prop("disabled", false); });');
    $this->registerJs('$("#kvgrid").on("grid.radiocleared", function(ev, key, val) { $("#monitoria-iddisc").val(""); $("#btnsubmit").prop("disabled", true); });');
?>