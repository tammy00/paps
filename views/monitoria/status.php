<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CursoSearch;
use app\models\DisciplinaSearch;
use app\models\Curso;
use app\models\Disciplina;

/* @var $this yii\web\View */
/* @var $model app\models\Monitoria */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(Yii::$app->user->identity->perfil === 'Secretaria'){ ?>
<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IDAluno')->textInput(['style'=>'width:200px', 'readonly' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(['0' => 'Aguardando Avaliação', '1' => 'Deferido', '2' => 'Indeferido', 'style'=>'width:600px']); ?>

        <?= $form->field($model, 'bolsa')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php } ?>
