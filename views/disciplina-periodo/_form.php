<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\DisciplinaSearch;
use app\models\CursoSearch;
use app\models\UsuarioSearch;
use app\models\Disciplina;
use app\models\Curso;
use app\models\Usuario;
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

    <?= $form->field($model, 'idCurso')->dropDownList(ArrayHelper::map(Curso::find()->orderBy('nome')->asArray()->all(), 'id', 'nome'), 
        ['prompt'=>'Selecione um curso', 'style'=>'width:300px']); ?>

    <?= $form->field($model, 'idProfessor')->dropDownList(ArrayHelper::map(Usuario::find()->where(['perfil' => 'Professor'])->orderBy('name')->asArray()->all(), 'id', 'name'),
        ['prompt'=>'Selecione o professor', 'style'=>'width:600px']); ?>

    <?= $form->field($model, 'nomeUnidade')->textInput(['maxlength' => true, 'style'=>'width:600px']) ?>

    <?= $form->field($model, 'numPeriodo')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'anoPeriodo')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'dataInicioPeriodo')->widget(
        DatePicker::className(), [
        // inline too, not bad
         'inline' => false, 
         'language' => 'pt', 
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
         'language' => 'pt', 
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

    <?= $form->field($model, 'qtdVagas')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'qtdMonitorBolsista')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'qtdMonitorNaoBolsista')->textInput(['style'=>'width:130px']) ?>

    <div class="form-group">
        <a href="?r=disciplina-periodo/index" class="btn btn-default">Voltar</a>
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>