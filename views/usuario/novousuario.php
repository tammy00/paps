<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <h2>Informe seu CPF</h2>
    <div class="form-group">
        <?= Html::input('text','cpf') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php 

    	if(isset($erro))
    	{
    		echo "<p class='col-sm-4 alert alert-danger'>";
    		echo $erro ;
    		echo "</p>";
    	}
    ?>
    </p>

<?php ActiveForm::end(); ?>
