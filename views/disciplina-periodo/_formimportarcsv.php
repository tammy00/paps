<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */
/* @var $form yii\widgets\ActiveForm */
/* @var string $terminou */

/* <?= $form->field($model, 'file')->fileInput(['options' => ['accept' => 'csv']]) ?> */

?>

<div class="disciplina-periodo-form">

        <?php if (!$model->errors) { ?>

            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

		    <?= $form->field($model, 'file')->fileInput() ?>

		    <div class="form-group">
		        <?= Html::submitButton('Importar', ['class' => 'btn btn-primary']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

	    <?php } else { ?>

		<?php if ($model->errors) { ?>
			<div class="alert alert-warning">
			  <strong>Atenção!</strong> Erro no processamento do arquivo.
			  <br><br>
			  
			  <?php $form = ActiveForm::begin(); ?>
			  <?= $form->errorSummary($model); ?>

			  <br><br>
			  <a href="index.php?r=disciplina-periodo/importarcsv" class="btn btn-primary btn-large">Voltar</a>

			  <?php ActiveForm::end(); ?>

			</div>
        <?php } else { ?>
        	<div class="alert alert-success">
        		<strong>Sucesso!</strong> Importação concluída.
        		<br><br>
        		<a href="index.php?r=disciplina-periodo/index" class="btn btn-success btn-large">Exibir Listagem</a>
        	</div>
        <?php } } ?>

</div>