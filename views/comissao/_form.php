<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Usuario;

/* @var $this yii\web\View */
/* @var $model app\models\Comissao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comissao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idProfessor')->dropDownList(ArrayHelper::map(Usuario::find()->where(['perfil' => 'Professor'])->orderBy('name')->asArray()->all(), 'id', 'name'),
    ['prompt'=>'Selecione o professor', 'style'=>'width:600px']); ?>

    <div class="form-group">
    	<a href="?r=comissao/index" class="btn btn-default">Voltar</a>
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
