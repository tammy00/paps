<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <h3>Data(s) selecionada(s) incorreta(s)</h3>
    <p>Não selecione uma data inicial que já passou, nem uma data final que seja menor que a inicial.</p>

    <div class="form-group">
		<a href="?r=periodo-inscricao-monitoria/index" class="btn btn-default">Início</a>
	</div>

<?php ActiveForm::end(); ?>