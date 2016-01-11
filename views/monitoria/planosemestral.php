<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>

<h2>Plano Semestral de Monitoria do Período <?php echo $model->ano .'/'. $model->periodo ?> </h2> 

<br><br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => [
            'nomeDisciplina',
            'nomeCurso',
            'nomeProfessor',
            'qtdVagas',
            'lab_traducao',
            'qtdMonitorBolsista',
            'qtdMonitorNaoBolsista'
        ],
    ]); ?>

<?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= $form->field($model, 'justificativa')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group">
        <a href="?r=monitoria/secretaria" class="btn btn-default">Voltar</a> 
        <?= Html::submitButton('Gerar PDF', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
