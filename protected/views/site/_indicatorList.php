<div class="indicators" ng-if="main.modals.indicator == 'list'">
  <a href ng-click="main.onCreateIndicator()" class="btn btn-primary btn-sm m-b-10" title="<?php echo Yii::t('i18n', 'create-indicator') ?>">
    <i class="glyphicon glyphicon-plus"></i>
    <?php echo Yii::t('i18n', 'create-indicator') ?>
  </a>

  <button type="button" class="btn btn-primary btn-sm m-b-10" data-animation="am-flip-x" bs-dropdown aria-haspopup="true" aria-expanded="false"><?php echo Yii::t('i18n', 'export') ?></button>
  <ul class="dropdown-menu" role="menu">
    <li>
      <a href ng-click="main.onExport(main.indicators)">
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

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th><?php echo Yii::t('i18n', 'name') ?></th>
        <th><?php echo Yii::t('i18n', 'measure') ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="indicator in main.indicators">
        <td>{{ indicator.id }}</td>
        <td>{{ indicator.name }}</td>
        <td>{{ indicator.measure }}</td>
        <td>
          <a href ng-click="main.onUpdateIndicator(indicator)" class="btn btn-primary btn-xs" title="<?php echo Yii::t('i18n', 'update-indicator') ?>">
            <i class="glyphicon glyphicon-pencil"></i>
          </a>
          <a href ng-click="main.onDeleteIndicator(indicator, $index)" class="btn btn-default btn-xs" title="<?php echo Yii::t('i18n', 'delete-indicator') ?>">
            <i class="glyphicon glyphicon-trash"></i>
          </a>
        </td>
      </tr>
    </tbody>
  </table>
</div>