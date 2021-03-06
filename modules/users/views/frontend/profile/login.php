<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-frontend-default-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'Login to the site to start the session'); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="form-group text-muted">
                <?= Module::t('module', 'If you have forgotten your password, click {:Link}', [':Link' => Html::a(Module::t('module', 'Here'), ['profile/request-password-reset'])]) . '.'; ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-log-in"></span> ' . Module::t('module', 'Sign In'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
