<?php

use yii\helpers\Html;


?>
<div>
    <h4>Selecione o ano</h4>
    <div class="form-group">
        <?= Html::input('text','ano') ?>
    </div>

        <h4>Selecione o semestre</h4>
    <div class="form-group">
        <?= Html::input('text','semestre') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'default']) ?>
    </div>
</div>