<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <h3>Parece que...</h3>
    <div class="form-group">
        Deu certo até agora.
    </div>

     <?php 
        if(isset($erro))
        {
            echo "<p class='col-sm-4 alert alert-danger'>";
            echo $erro ;
            echo "</p>";
        }
    ?>

<?php ActiveForm::end(); ?>