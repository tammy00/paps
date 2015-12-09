<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <h3>Data(s) selecionada(s) incorreta(s)</h3>
    <p>Não selecione uma data inicial que já passou, nem uma data final que seja menor que a inicial.</p>



<?php ActiveForm::end(); ?>