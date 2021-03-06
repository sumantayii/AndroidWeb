<?php
/**
 * Created by PhpStorm.
 * User: Alexey Sсhevchenko <ivanovosity@gmail.com>
 * Date: 09.10.16
 * Time: 3:20
 */

namespace modules\users\models\frontend;

use Yii;
use yii\helpers\ArrayHelper;
use modules\users\Module;

/**
 * Class User
 * @package modules\users\models\frontend
 */
class User extends \modules\users\models\User
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    const SCENARIO_AVATAR_UPDATE = 'avatarUpdate';
    const SCENARIO_PASSWORD_UPDATE = 'passwordUpdate';
    const SCENARIO_PROFILE_DELETE = 'profileDelete';

    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['newPassword', 'newPasswordRepeat', 'currentPassword'], 'required', 'on' => self::SCENARIO_PASSWORD_UPDATE],
            ['newPassword', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validateCurrentPassword', 'skipOnEmpty' => false, 'skipOnError' => false],
        ]);
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!empty($this->newPassword) && !empty($this->newPasswordRepeat) && !$this->hasErrors()) {
            if($this->$attribute) {
                if (!$this->validatePassword($this->$attribute))
                    $this->addError($attribute, Module::t('module', 'Incorrect current password.'));
            } else {
                $this->addError($attribute, Module::t('module', 'Enter your current password.'));
            }
        } else {
            $this->addError($attribute, Module::t('module', 'Not all fields are filled in correctly.'));
        }
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = ['email', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_AVATAR_UPDATE] = ['isDel'];
        $scenarios[self::SCENARIO_PASSWORD_UPDATE] = ['currentPassword', 'newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_PROFILE_DELETE] = ['status'];
        $scenarios['default'] = ['username', 'email', 'password_hash', 'status', 'auth_key', 'email_confirm_token'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'currentPassword' => Module::t('module', 'Current Password'),
            'newPassword' => Module::t('module', 'New Password'),
            'newPasswordRepeat' => Module::t('module', 'Repeat Password'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->newPassword)) {
                $this->setPassword($this->newPassword);
                Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Защита от удаления самого себя
        if ($this->id == Yii::$app->user->identity->getId()) {
            return false;
        }
        return true;
    }
}