<?php

namespace mdm\admin\models\form;

use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Update extends Model
{
    public $id;
    public $username;
    public $full_name;
    public $avatar;
    public $email;
    public $password;
    public $retypePassword;

    private $_user;

    /**
     * Constructor.
     *
     * @param integer $id
     * @param array $config
     */
    public function __construct($id, $config = [])
    {
        $this->id = $id;
        parent::__construct($config);
        $this->_user = User::findOne($id);
        if ($this->_user) {
            $this->username = $this->_user->username;
            $this->full_name = $this->_user->full_name;
            $this->avatar = $this->_user->avatar;
            $this->email = $this->_user->email;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ?: User::class;
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => $class, 'targetAttribute' => 'username',
                'message' => 'This username has already been taken.',
                'when' => function($model) {
                    return $model->username !== $model->_user->username;
                }
            ],

            ['full_name', 'filter', 'filter' => 'trim'],
            ['full_name', 'required'],
            ['full_name', 'string', 'max' => 255],

            ['avatar', 'string', 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'targetAttribute' => 'email',
                'message' => 'This email address has already been taken.',
                'when' => function($model) {
                    return $model->email !== $model->_user->email;
                }
            ],

            [['password', 'retypePassword'], 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
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
            'telegram_chat_id' => 'Телеграм ID чата',
            'retypePassword' => 'Повторите пароль',
        ];
    }

    /**
     * Updates user details.
     *
     * @return User|null the updated model or null if saving fails
     */
    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->username = $this->username;
            $user->full_name = $this->full_name;
            $user->avatar = $this->avatar;
            $user->email = $this->email;

            if (!empty($this->password)) {
                $user->setPassword($this->password);
                $user->generateAuthKey();
            }

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
