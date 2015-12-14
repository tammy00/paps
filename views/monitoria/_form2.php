<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Monitoria */
/* @var $form yii\widgets\ActiveForm */
/* @var string $etapa */
/* @var string $periodo */
/* @var string $matricula */
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
        ],
        [
            'label' => 'Disciplina',
            'value' => $model->nomeDisciplina
        ],
        [
            'label' => 'Professor',
            'value' => $model->nomeProfessor
        ]
    ],
    'options' => [
        'class' => 'table table-striped table-bordered detail-view',
        'style' => 'width:600px'
    ],
]) ?>

<div class="monitoria-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?php if ($model->errors) { ?>
            <?= $form->errorSummary($model); ?>
        <?php } ?>
        
        <?= $form->field($model, 'anoConclusao')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'semestreConclusao')->dropDownList(['' => '', '1' => '1', '2' => '2'], ['style'=>'width:60px']) ?>
        <?= $form->field($model, 'mediaFinal')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'file')->fileInput() ?>
        <?= $form->field($model, 'bolsa')->checkbox() ?>

        <div id="dadosbancarios" style="display: none">
            <?= $form->field($model, 'banco')->textInput(['style'=>'width:100px']) ?>
            <?= $form->field($model, 'agencia')->textInput(['style'=>'width:100px']) ?>
            <?= $form->field($model, 'conta')->textInput(['style'=>'width:100px']) ?>
        </div>

        <!-- Repassando para o form os campos já setados anteriormente, pois a submissão do form somente persiste os campos setados nele-->
        <?= $form->field($model, 'IDDisc')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'IDAluno')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'IDperiodoinscr')->hiddenInput()->label(false) ?>

        <?= Html::hiddenInput('step', $etapa) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJs('
        $(document).ready(function(){
            $("#monitoria-bolsa").change(function(){
                if (!$("#monitoria-bolsa").is(":checked")) {
                    $("#monitoria-banco").val("");
                    $("#monitoria-agencia").val("");
                    $("#monitoria-conta").val("");
                }
                $("#dadosbancarios").toggle();
            });
        });'
    );
?>