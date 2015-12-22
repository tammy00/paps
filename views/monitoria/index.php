<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitorias';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if(isset(Yii::$app->user->identity)){ ?>
<div class="monitoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="jumbotron">
        <?php if(Yii::$app->user->identity->perfil == 'Aluno') { ?>
            <p> <?= Html::a('Inscrição', ['create'], ['class' => 'btn btn-success']) ?>   </p>
            <p> <?= Html::a('Gerenciar Monitorias', ['inscricaoaluno'], ['class' => 'btn btn-success']) ?> </p>
            <p> <?= Html::a('Gerar Relatório Semestral', ['gerarrelatoriosemestral'], ['class' => 'btn btn-success']) ?> </p>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil == 'Secretaria'){ ?>
            <p><?= Html::a('Gerenciar Período de Inscrição', ['/periodo-inscricao-monitoria/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas UFAM', ['/disciplina/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Selecionar Disciplinas Monitoria', ['/disciplina-periodo/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Gerenciar Monitorias', ['inscricaosecretaria'], ['class' => 'btn btn-success']) ?></p>
        <?php } ?>

    </div>

</div>
<?php } ?>
