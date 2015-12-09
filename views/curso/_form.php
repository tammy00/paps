<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
    	<?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

  		<?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

   		<?= $form->field($model, 'max_horas')->textInput() ?>

   		<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
      
    </div>
    

    

    <?php ActiveForm::end(); ?>

</div>
