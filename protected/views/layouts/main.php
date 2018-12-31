<?php /* @var $this Controller */ ?>
<?php $nextLanguage = $this->nextLanguage(); ?>
<!DOCTYPE html>
<html ng-app="app">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="language" content="en">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/paper.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/angular-csp.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/rzslider.min.css">

  <title><?php echo CHtml::encode($this->pageTitle); ?></title>

  <script type="text/javascript">
    window.language             = '<?php echo Yii::app()->language; ?>';
    window.login                = '<?php echo !Yii::app()->user->isGuest; ?>';
    window.errorRestrictKeys    = '<?php echo Yii::t("i18n", "error-restrict-keys"); ?>';
  </script>
</head>

<body ng-controller="Main as main">

  <header>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ICWC_logo.png" />
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

          <ul class="nav navbar-nav group-select">
            <li class="dropdown">
              <a href class="dropdown-toggle" bs-dropdown role="button" aria-expanded="false">
                {{ main.onGetSelectedIndicator() || '<?php echo Yii::t('i18n', 'cb-indicator') ?>' }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li ng-repeat="indicator in main.indicators" ng-class="{'active':indicator.id === main.selection.indicator.id}">
                  <a href ng-click="main.onSelectIndicator(indicator)">{{ indicator.name }}</a>
                </li>
              </ul>
            </li>
          </ul>

          <form class="navbar-form navbar-right ng-cloak">

            <button ng-if="!main.login"
              bs-modal type="button" data-animation="am-fade-and-scale"
              class="btn btn-link"
              data-template-url="{{ main.templates.login }}"
              data-container="body"
              title="<?php echo Yii::t('i18n', 'enter') ?>">
              <i class="glyphicon glyphicon-log-in"></i>
              <?php echo Yii::t('i18n', 'enter') ?>
            </button>

            <button ng-if="main.login"
              type="button" data-animation="am-fade-and-scale"
              class="btn btn-link"
              ng-click="main.onBeforeShowDatas(main.selection.rayon)"
              title="<?php echo Yii::t('i18n', 'datas') ?>">
              <i class="glyphicon glyphicon-globe"></i>
              <?php echo Yii::t('i18n', 'datas') ?>
            </button>

            <button ng-if="main.login"
              bs-modal type="button" data-animation="am-fade-and-scale"
              class="btn btn-link"
              data-template-url="{{ main.templates.indicators }}"
              data-container="body"
              title="<?php echo Yii::t('i18n', 'indicators') ?>">
              <i class="glyphicon glyphicon-align-justify"></i>
              <?php echo Yii::t('i18n', 'indicators') ?>
            </button>

            <?php echo CHtml::link(
              Yii::t('i18n', 'exit'),
              array('site/logout'),
              array('class' => 'btn btn-link', 'ng-if' => 'main.login')
            ); ?>

            <?php echo CHtml::link(
              $nextLanguage['text'],
              array('', 'language' => $nextLanguage['id']),
              array('class' => 'btn btn-success')
            ); ?>

          </form>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>

  <div id="map">
    <ya-map ya-zoom="{{main.map.zoom}}" ya-after-init="main.map.afterInit($target)">
    </ya-map>
    <div class="year-select">
      <div class="year-select-controls">
        <a href class="btn btn-default btn-sm play" ng-click="!main.yearInterval ? main.onIntervalYear() : main.onIntervalClear()">{{ main.selection.year }}
          <i class="glyphicon glyphicon-play" ng-if="!main.yearInterval"></i>
          <i class="glyphicon glyphicon-pause" ng-if="main.yearInterval"></i>
        </a>
      </div>
      <rzslider
        rz-slider-model="main.selection.year"
        rz-slider-options="main.slider.options"
      ></rzslider>
    </div>
  </div>


  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/FileSaver.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/xlsx.full.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/angular.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/angular-sanitize.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/angular-strap.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/angular-strap.tpl.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/angular-animate.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/ya-map-2.1.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/dependencies/rzslider.min.js"></script>

  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/app/app.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/app/config.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/app/controller.main.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/app/factory.query.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ng-modules/app/directive.import.js"></script>
  <script type="text/javascript">
    window.rayons = <?php echo json_encode(Rayon::model()->getAll()); ?>;
  </script>

</body>
</html>
