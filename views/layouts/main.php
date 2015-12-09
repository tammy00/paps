<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\assets\AppAsset;
use kartik\icons\Icon;
Icon::map($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <header style="border-bottom:1px solid #e7e7e7; padding:5px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <img src="icomp.png" width="150px" />
                    </div>
                    <div class="col-md-8">
                        <h2 style="text-align:center;">Sistema de Atividades Complementares</h2>
                    </div>
                    <div class="col-md-2">
                        <img src="ufam.png" width="70px" />
                    </div>
                </div>
            </div>
        </header>
        
            <div id="wrapper">
                <!-- /.navbar-top-links -->

                <?php if(isset(Yii::$app->user->identity)){ ?>


                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group">
                                    Olá, 
                                    <b><?= Yii::$app->user->identity->name ?></b>
                                    , você está logado como: 
                                    <b><?= Yii::$app->user->identity->perfil ?></b>
                                </div>
                                <!-- /input-group -->
                            </li>
                         <!--  <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>-->
                            <?php if(Yii::$app->user->identity->isAdmin == 1){ ?>
                            <li>
                                <a href="?r=curso/index" ><i class="fa fa-check fa-fw"></i> Curso</a>
                            </li>
                            <li>
                                <a href="?r=periodo/index"><i class="fa fa-calendar fa-fw"></i> Período</a>
                            </li>
                            <li>
                                <a href="?r=usuario/index"><i class="fa fa-user fa-fw"></i> Usuários</a>
                            </li>
							<li>
                                <a href="?r=monitoria/index"><i class="fa fa-eye fa-fw"></i> Monitoria</a>
                            </li>
                            <?php } ?>
                            <?php if(Yii::$app->user->identity->perfil == 'Coordenador'){ ?>
                                <li>
                                    <a href="?r=solicitacao/index"><i class="fa fa-download fa-fw"></i> Solicitações</a>
                                </li>
                                <li>
                                    <a href="?r=grupo/index"><i class="fa fa-users fa-fw"></i> Grupos</a>
                                </li>
                                <li>
                                    <a href="?r=atividade/index"><i class="fa fa-tasks fa-fw"></i> Atividades</a>
                                </li>
                            <?php } ?>
                          <!--   <li>
                                <a href="#"><i class="fa fa-line-chart fa-fw"></i> Relatório</a>
                            </li>
                           <!-- <li>
                                <a href="?r=curso/index"><i class="fa fa-file-text fa-fw"></i> Relação de Atividades</a>
                            </li>-->
                             <li>
                                <a href="?r=site/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
                <?php } ?>

                <div id="page-wrapper" style="padding:10px; overflow:auto;">
                    <?= $content ?>
                </div>
            </div>
            
        
        <footer style="text-align:center; border-top:1px solid #e7e7e7;">
            <div class="col-md-12">
                <h5>Sistema Desenvolvido no Contexto da Disciplina ICC410 - UFAM - ICOMP</h5>
            </div>
        </footer>
        <?php $this->endBody() ?>
    </body>
    <!-- Scripts -->
</html>
<?php $this->endPage() ?>