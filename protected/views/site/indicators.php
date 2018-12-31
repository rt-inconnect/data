<div class="modal top am-fade-and-scale" tabindex="-1" role="dialog" style="display: block;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" ng-click="$hide()">×</button>
        <h4 class="modal-title"><?php echo Yii::t('i18n', 'indicators') ?></h4>
      </div>
      <div class="modal-body">

        <?php $this->renderPartial('_indicatorList'); ?>
        <?php $this->renderPartial('_indicatorForm'); ?>
        <div class="preloader" ng-if="main.modals.indicatorLoading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/preloader.gif" /></div>

      </div>
    </div>
  </div>
</div>
