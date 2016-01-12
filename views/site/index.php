<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $model app\models\Usuario */

?>
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
                                <li>
                                    <a href="?r=monitoria/index"><i class="fa fa-eye fa-fw"></i> Monitoria</a>
                                </li>
                            <?php } ?>
                            <?php if(Yii::$app->user->identity->perfil == 'Aluno'){ ?>
                                <li>
                                    <a href="?r=monitoria/index"><i class="fa fa-eye fa-fw"></i> Monitoria</a>
                                </li>
                            <?php } ?>
                            <?php if(Yii::$app->user->identity->perfil == 'Professor'){ ?>
                                <li>
                                    <a href="?r=monitoria/index"><i class="fa fa-eye fa-fw"></i> Monitoria</a>
                                </li>
                            <?php } ?>
                            <?php if(Yii::$app->user->identity->perfil == 'Secretaria'){ ?>
                                <li>
                                    <a href="?r=monitoria/index"><i class="fa fa-eye fa-fw"></i> Monitoria</a>
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
                    <h1>Bem Vindo</h1>
                </div>
            </div>