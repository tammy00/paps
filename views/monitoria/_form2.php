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
            <div class="alert alert-warning">
                <strong>Atenção!</strong>
                <br>
                <?= $form->errorSummary($model); ?>
            </div>            
        <?php } ?>
        
        <?= $form->field($model, 'anoConclusao')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'semestreConclusao')->dropDownList(['' => '', '1' => '1', '2' => '2'], ['style'=>'width:60px']) ?>
        <?= $form->field($model, 'mediaFinal')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'file')->fileInput() ?>
        <?= $form->field($model, 'bolsa')->checkbox() ?>

        <!--<div id="dadosbancarios" style="display: none">-->
        <div id="dadosbancarios">
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
            <a href="?r=monitoria/create" class="btn btn-default">Voltar</a>
            <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    
    //$this->registerJs('
    //    $(document).ready(function(){
    //        $("#monitoria-bolsa").change(function(){
    //            if (!$("#monitoria-bolsa").is(":checked")) {
    //                $("#monitoria-bolsa").val("0");
    //                $("#monitoria-banco").val("");
    //                $("#monitoria-agencia").val("");
    //                $("#monitoria-conta").val("");
    //            } else { $("#monitoria-bolsa").val("1"); }
    //            $("#dadosbancarios").toggle();
    //        });
    //    });'
    //);

    $this->registerJs('
        $(document).ready(function(){
            if ($("#monitoria-bolsa").is(":checked"))
                $("#dadosbancarios").prop("style", "display: block");
            else
                $("#dadosbancarios").prop("style", "display: none");
        });'
    );

    $this->registerJs('
        $(document).ready(function(){
            $("#monitoria-bolsa").change(function(){
                if ($("#monitoria-bolsa").is(":checked")) {
                    $("#monitoria-bolsa").val("1");
                    $("#dadosbancarios").prop("style", "display: block");
                }
                else {
                    $("#monitoria-bolsa").val("0");
                    $("#monitoria-banco").val("");
                    $("#monitoria-agencia").val("");
                    $("#monitoria-conta").val("");
                    $("#dadosbancarios").prop("style", "display: none");
                }
            });
        });'
    );

    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.price_format.2.0.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

    $this->registerJs('
        $(document).ready(function(){
            $("#monitoria-mediafinal").priceFormat({
            prefix: "",
            centsSeparator: ".",
            thousandsSeparator: "",
            limit: 4,
            centsLimit: 2,
            allowNegative: false,
            });
        });
    ');
?>