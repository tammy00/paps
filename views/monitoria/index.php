<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Usuario;
use app\models\Comissao;

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

    <br>
    <?php if ( $erro == 1 ) { ?>
        <div class="alert alert-warning">
            <strong>Atenção!</strong> Você não está cadastrado como monitor.
        </div>
    <?php } ?>

    <?php if ( $erro == 2 ) { ?>
        <div class="alert alert-warning">
            <strong>Atenção!</strong> O último período cadastrado não possui registros de monitoria.
        </div>
    <?php } ?>

    <div style="background-color: white;">
        <?php if(Yii::$app->user->identity->perfil == 'Aluno') { ?>
            <p> <?= Html::a('Inscrição', ['create'], ['class' => 'btn btn-success']) ?>   </p>
            <p> <?= Html::a('Gerenciar Monitorias', ['aluno'], ['class' => 'btn btn-success']) ?> </p>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil == 'Secretaria'){ ?>
            <p><?= Html::a('Período de Inscrição', ['/periodo-inscricao-monitoria/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas', ['/disciplina/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas para Monitoria', ['/disciplina-periodo/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Comissão Avaliadora', ['/comissao/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Gerenciar Monitorias', ['secretaria'], ['class' => 'btn btn-success']) ?></p>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil == 'Professor'){ ?>

            <?php 
                //Pega professor baseando-se no CPF do usuário logado
                $professor = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
                $comissao = Comissao::findOne(['idProfessor' => $professor->id]);
                if ($comissao != null && $comissao->idProfessor != null) {
            ?>
                <p> <?= Html::a('Julgar Inscrições', ['avaliador'], ['class' => 'btn btn-success']) ?> </p>
            <?php } ?>

            <p> <?= Html::a('Gerenciar Monitorias', ['professor'], ['class' => 'btn btn-success']) ?> </p>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil == 'Coordenador'){ ?>
            <p><?= Html::a('Gerenciar Período de Inscrição', ['/periodo-inscricao-monitoria/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas', ['/disciplina/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas para Monitoria', ['/disciplina-periodo/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Comissão Avaliadora', ['/comissao/index'], ['class' => 'btn btn-success']) ?></p>

            <?php 
                //Pega professor baseando-se no CPF do usuário logado
                $professor = Usuario::findOne(['CPF' => Yii::$app->user->identity->cpf]);
                $comissao = Comissao::findOne(['idProfessor' => $professor->id]);
                if ($comissao != null && $comissao->idProfessor != null) {
            ?>
                <p> <?= Html::a('Julgar Inscrições', ['avaliador'], ['class' => 'btn btn-success']) ?> </p>
            <?php } ?>
            
            <p><?= Html::a('Gerenciar Monitorias - Secretaria', ['secretaria'], ['class' => 'btn btn-success']) ?></p>
            <p> <?= Html::a('Gerenciar Monitorias - Professor', ['professor'], ['class' => 'btn btn-success']) ?> </p>
        <?php } ?>

        <?php if(Yii::$app->user->identity->perfil == 'admin'){ ?>
            <p><?= Html::a('Gerenciar Período de Inscrição', ['/periodo-inscricao-monitoria/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas', ['/disciplina/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Disciplinas para Monitoria', ['/disciplina-periodo/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Comissão Avaliadora', ['/comissao/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Gerenciar Monitorias - Secretaria', ['secretaria'], ['class' => 'btn btn-success']) ?></p>
            <p> <?= Html::a('Gerenciar Monitorias - Professor', ['professor'], ['class' => 'btn btn-success']) ?> </p>
        <?php } ?>
    </div>

</div>
<?php } ?>
