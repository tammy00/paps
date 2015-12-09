<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\DisciplinaSearch;
use app\models\CursoSearch;
use app\models\ProfessorSearch;
use app\models\Disciplina;
use app\models\Curso;
use app\models\Professor;
//use yii\jui\DatePicker;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- <?php //foreach (Yii::$app->session->getAllFlashes() as $key => $message) { echo '<div class="alert alert-' . $key . '" role="alert">' . $message . '</div>'; }?> -->

<div class="disciplina-periodo-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->errorSummary($model); ?> -->

    <?= $form->field($model, 'idDisciplina')->dropDownList(ArrayHelper::map(Disciplina::find()->orderBy('nomeDisciplina')->asArray()->all(), 'id', 'nomeDisciplina'), 
        ['prompt'=>'Selecione uma disciplina', 'style'=>'width:600px']); ?>

    <?= $form->field($model, 'codTurma')->textInput(['maxlength' => true, 'style'=>'width:130px']) ?>

    <?= $form->field($model, 'idCurso')->dropDownList(ArrayHelper::map(Curso::find()->orderBy('nome')->asArray()->all(), 'ID', 'nome'), 
        ['prompt'=>'Selecione um curso', 'style'=>'width:300px']); ?>

    <?= $form->field($model, 'idProfessor')->dropDownList(ArrayHelper::map(Professor::find()->orderBy('Nome')->asArray()->all(), 'ID', 'Nome'),
        ['prompt'=>'Selecione o professor', 'style'=>'width:600px']); ?>

    <?= $form->field($model, 'nomeUnidade')->textInput(['maxlength' => true, 'style'=>'width:600px']) ?>

    <?= $form->field($model, 'qtdVagas')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'numPeriodo')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'anoPeriodo')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'dataInicioPeriodo')->widget(
        DatePicker::className(), [
        // inline too, not bad
         'inline' => false, 
        // modify template for custom rendering
        //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
        'template' => '{addon}{input}',
        'options' => ['style'=>'width:130px'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
            ]
    ]) ?>

    <?= $form->field($model, 'dataFimPeriodo')->widget(
        DatePicker::className(), [
        // inline too, not bad
         'inline' => false, 
        // modify template for custom rendering
        //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
        'template' => '{addon}{input}',
        'options' => ['style'=>'width:130px'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
            ]
    ]) ?>

    <?= $form->field($model, 'usaLaboratorio')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>