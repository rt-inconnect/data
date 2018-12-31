<form name="Indicator" ng-if="main.modals.indicator == 'form'">
  <div class="form-group">
    <label class="control-label" for="indicatorRuName"><?php echo Yii::t('i18n', 'ruName') ?></label>
    <input class="form-control" id="indicatorRuName" type="text" ng-model="main.form.indicator.name_ru">
  </div>
  <div class="form-group">
    <label class="control-label" for="indicatorEnName"><?php echo Yii::t('i18n', 'enName') ?></label>
    <input class="form-control" id="indicatorEnName" type="text" ng-model="main.form.indicator.name_en">
  </div>
  <div class="form-group">
    <label class="control-label" for="indicatorRuMeasure"><?php echo Yii::t('i18n', 'ruMeasure') ?></label>
    <input class="form-control" id="indicatorRuMeasure" type="text" ng-model="main.form.indicator.measure_ru">
  </div>
  <div class="form-group">
    <label class="control-label" for="indicatorEnMeasure"><?php echo Yii::t('i18n', 'enMeasure') ?></label>
    <input class="form-control" id="indicatorEnMeasure" type="text" ng-model="main.form.indicator.measure_en">
  </div>

  <div class="form-group">
    <label class="control-label" for="indicatorColor"><?php echo Yii::t('i18n', 'color') ?></label>
    <input class="form-control" id="indicatorColor" type="color" ng-model="main.form.indicator.color">
  </div>

  <div class="form-actions">
    <button type="button" class="btn btn-default" ng-click="main.modals.indicator = 'list'"><?php echo Yii::t('i18n', 'back') ?></button>
    <button type="button" class="btn btn-primary" ng-click="main.onSaveIndicator(main.form.indicator)"><?php echo Yii::t('i18n', 'save') ?></button>
  </div>
</form>