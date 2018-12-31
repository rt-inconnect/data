<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<div class="modal top am-fade-and-scale" tabindex="-1" role="dialog" style="display: block;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" ng-click="$hide()">×</button>
        <h4 class="modal-title"><?php echo Yii::t('i18n', 'login'); ?></h4>
      </div>
      <div class="modal-body">

        <form name="Login">
          <div class="form-group">
            <label class="control-label" for="loginUsername"><?php echo Yii::t('i18n','username') ?></label>
            <input class="form-control" id="loginUsername" type="text" ng-model="main.form.user.username">
          </div>
          <div class="form-group">
            <label class="control-label" for="loginPassword"><?php echo Yii::t('i18n', 'password') ?></label>
            <input class="form-control" id="loginPassword" type="password" ng-model="main.form.user.password">
          </div>
          <div class="form-group">
            <div class="checkbox">
            <label>
              <input name="loginPassword" ng-model="main.form.user.rememberMe" type="checkbox"> <?php echo Yii::t('i18n', 'remember') ?>
            </label>
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="$hide()"><?php echo Yii::t('i18n', 'close') ?></button>
        <button type="button" class="btn btn-primary" ng-click="main.Login(main.form.user, $hide)"><?php echo Yii::t('i18n', 'enter') ?></button>
      </div>
    </div>
  </div>
</div>