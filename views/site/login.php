<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
    <div class="navbar-default sidebar" role="navigation">
        <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => ['labelOptions' => ['class' => 'control-label'],
        ],
        ]); ?>
        <div class="sidebar-nav navbar-collapse">
            <div class="row">
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-9">

                    <?= $form->field($model, 'cpf')->label('CPF') ?>
                    <?= $form->field($model, 'password')->passwordInput()->label('Senha') ?>
                    <div class="form-group">
                        <button type="submit" name="login-button" class="btn btn-success">Entrar</button>
                    </div>
                    <div class="form-group">
                        <a href="?r=usuario/recuperarsenha">Solicitar nova senha</a>
                        <br>
                        <a href="?r=usuario/novousuario">Registrar aluno</a>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
    <?php ActiveForm::end(); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-4">
            </div>
            
        </div>
        
    </div>
</div>