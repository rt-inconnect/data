<div class="modal top am-fade-and-scale" tabindex="-1" role="dialog" style="display: block;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" ng-click="$hide()">×</button>
        <h4 class="modal-title"><?php echo Yii::t('i18n', 'datas') ?></h4>
      </div>
      <div class="modal-body">

        <div class="data-inputs m-b-30">
          <input bs-typeahead type="text" class="form-control"
            ng-model="main.selection.indicator"
            data-min-length="0"
            data-limit="10"
            data-animation="am-flip-x"
            bs-options="indicator.id as indicator.name for indicator in main.indicators"
            placeholder="<?php echo Yii::t('i18n', 'indicator') ?>"
          />

          <input bs-typeahead type="text" class="form-control"
            ng-model="main.selection.rayon"
            data-min-length="0"
            data-limit="10"
            data-animation="am-flip-x"
            bs-options="rayon.rayon_id as rayon.rayon for rayon in main.rayons"
            placeholder="<?php echo Yii::t('i18n', 'rayon') ?>"
          />

          <button type="button" class="btn btn-primary" data-animation="am-flip-x" bs-dropdown aria-haspopup="true" aria-expanded="false"><?php echo Yii::t('i18n', 'export') ?></button>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a href ng-click="main.onExport(main.datas)">
                <i class="glyphicon glyphicon-download"></i>&nbsp;<?php echo Yii::t('i18n', 'exportThis') ?></a>
            </li>
            <li>
              <a href="<?php echo Yii::app()->request->baseUrl; ?>/template.xlsx" target="_blank">
                <i class="glyphicon glyphicon-download"></i>&nbsp;<?php echo Yii::t('i18n', 'exportTemplates') ?></a>
            </li>
            <li>
              <a href ng-click="main.onExport(main.rayons)">
                <i class="glyphicon glyphicon-download"></i>&nbsp;<?php echo Yii::t('i18n', 'exportRayons') ?></a>
            </li>
          </ul>
          <div class="pull-right">
            <label for="import-file"><?php echo Yii::t('i18n', 'import') ?></label>
            <input id="import-file" type="file" import-xls="" multiple="false" />
          </div>
        </div>

        <table class="table table-striped" ng-if="main.imported.length == 0">
          <thead>
            <tr>
              <th><?php echo Yii::t('i18n', 'year') ?></th>
              <th><?php echo Yii::t('i18n', 'value') ?></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="data in main.datas">
              <td>{{ data.year }}</td>
              <td ng-dblclick="main.onDataSet(data)">{{ data.val }}</td>
            </tr>
          </tbody>
        </table>

        <div ng-if="main.imported.length > 0">
          <div class="alert alert-success"><?php echo Yii::t('i18n', 'import-success') ?> {{ main.imported.length }}</div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th><?php echo Yii::t('i18n', 'indicator_id') ?></th>
                <th><?php echo Yii::t('i18n', 'rayon_id') ?></th>
                <th><?php echo Yii::t('i18n', 'year') ?></th>
                <th><?php echo Yii::t('i18n', 'value') ?></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="data in main.imported">
                <td>{{ data.indicator_id }}</td>
                <td>{{ data.rayon_id }}</td>
                <td>{{ data.year }}</td>
                <td ng-dblclick="main.onDataSet(data)">{{ data.val }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="preloader" ng-if="main.modals.dataLoading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/preloader.gif" /></div>

      </div>
    </div>
  </div>
</div>
