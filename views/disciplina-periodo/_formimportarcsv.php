<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */
/* @var $form yii\widgets\ActiveForm */
/* @var string $etapa */
/* @var string $erroFatal */
/* @var array[] $erros */

?>

<div class="disciplina-periodo-form">

		<?php 
		if (!empty($erroFatal)) 
		{ ?>
        	<div class="alert alert-danger">
        		<strong>Erro!</strong> Erro fatal no processamento do arquivo. Os dados não foram salvos.
        		<br><br>
        		<?php echo $erroFatal; ?>
        	</div>
		<?php 
		} ?>

        <?php 
        if ($etapa == '1' || !empty($erroFatal)) 
        { ?>

            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

		    <?= $form->field($model, 'file')->fileInput() ?>

		    <strong>Atenção:</strong> O arquivo deve usar a vírgula (,) como separador de campos/colunas.<br><br>

		    <div class="form-group">
		    	<a href="?r=disciplina-periodo/index" class="btn btn-default">Voltar</a>
		        <?= Html::submitButton('Importar', ['class' => 'btn btn-success']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

	    <?php 
		} 
	    else 
		{ ?>
			<div class="alert alert-success">
				<strong>Sucesso!</strong> Importação concluída.
			</div>

			<?php 
			if ($erros) 
			{ ?>
				<div class="alert alert-warning">
				  	<strong>Atenção!</strong>
				  	<br>Porém houve erro no processamento dos registros listados abaixo.
				  	<br>Esses registros não foram salvos.
				  	<br><br>
				  	<ul>
				  	<?php foreach ($erros as $key => $value) { ?>
				  		<li><?php echo $value ?></li>
				  	<?php } ?>
				  	</ul>
				  	<br>
				  	<?php echo 'Total de erros: '. count($erros); ?>
				</div>
			<?php 
			} ?>
			
			<a href="index.php?r=disciplina-periodo/index" class="btn btn-primary btn-large">Visualizar Disciplinas</a>

			<?php if ($erros) { ?>
				<a href="index.php?r=disciplina-periodo/importarcsv" class="btn btn-success btn-large">Tentar Novamente</a>
			<?php } ?>

        <?php 
    	} 
    	?>

</div>