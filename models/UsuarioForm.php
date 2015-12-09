<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class UsuarioForm extends Model
{

    public $id ;
    public $name ;
    public $cpf ;
    public $email ;
    public $password ;
    public $matricula ;
    public $siape ;
    public $perfil ;
    public $dtEntrada ;
    public $isAdmin ;
    public $isAtivo ;

    public $isNewRecord ;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name','cpf', 'email','password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }



}
