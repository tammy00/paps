<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <h3>Data(s) selecionada(s) incorreta(s)</h3>

    <p><strong>NÃO</strong> selecionar datas que entrem nas seguintes condições:<br>
    	<b>1)</b> Data de início <u>anterior</u> à atual; <br>
    	<b>2)</b> Data de fim <u>menor que</u> a data de início;<br>
    	<b>3)</b> Datas de início e fim <u>iguais</u>.
    </p>

    <div class="form-group">
		<a href="?r=periodo-inscricao-monitoria/create" class="btn btn-default">Voltar</a>
		<a href="?r=periodo-inscricao-monitoria/index" class="btn btn-default">Períodos cadastrados</a>
	</div>

<?php ActiveForm::end(); ?>