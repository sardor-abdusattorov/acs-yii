<?php
namespace mdm\admin\models\form;

use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class Signup extends Model
{
    public $id;
    public $username;
    public $full_name;
    public $avatar;
    public $email;
    public $password;
    public $telegram_chat_id;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ?: 'mdm\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['full_name', 'filter', 'filter' => 'trim'],
            ['full_name', 'required'],
            ['full_name', 'string', 'max' => 255],

            ['avatar', 'string', 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 5],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Возвращает метки атрибутов.
     *
     * @return array метки атрибутов
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'full_name' => 'Полное имя',
            'avatar' => 'Аватар',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'retypePassword' => 'Повторите пароль',
            'telegram_chat_id' => 'Телеграм ID чата',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ?: 'mdm\admin\models\User';
            $user = new $class();
            $user->username = $this->username;
            $user->full_name = $this->full_name;
            $user->avatar = $this->avatar;
            $user->email = $this->email;
            $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
