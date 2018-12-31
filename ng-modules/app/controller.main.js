(function () {
  'use strict';

  var _map, _objectManager;

  var _year = {
    min: 2000,
    max: (new Date()).getFullYear()
  };

  Array.prototype.max = function() {
    return Math.max.apply(null, this);
  };

  Array.prototype.min = function() {
    return Math.min.apply(null, this);
  };

  angular
  .module('controller.main', [])
  .controller('Main', ['$scope', '$rootScope', '$timeout', '$interval', '$modal', 'API', 'Query', MainCtrl]);

  /* Main Controller */
  function MainCtrl ($scope, $rootScope, $timeout, $interval, $modal, API, Query) {

    /* Declaring Controllers Public functions and variables */
    $scope.vm                    = this;
    $scope.vm.login              = window.login;
    $scope.vm.language           = window.language;
    $scope.vm.yearInterval       = false;

    $scope.vm.polygons           = [];
    $scope.vm.indicators         = [];
    $scope.vm.years              = [];
    $scope.vm.datas              = [];
    $scope.vm.imported           = [];
    $scope.vm.values             = {};
    $scope.vm.rayons             = rayons;

    $scope.vm.form               = { user: {}, indicator: {} };
    $scope.vm.selection               = {
      year                           : _year.max,
      indicator                      : '',
      rayon                          : ''
    };
    $scope.vm.templates          = {
      login                          : API.Templates + 'login',
      datas                          : API.Templates + 'datas',
      indicators                     : API.Templates + 'indicators'
                                   };

    $scope.vm.modals             = {
      indicator                      : 'list',
      indicatorLoading               : false,
      dataLoading                    : false
                                   };

    $scope.vm.Login              = Login;

    $scope.vm.map = {
      zoom: 6,
      afterInit: afterInit
    };


    var dateTimeout;
    $scope.vm.slider = {
      options: {
        floor: _year.min,
        ceil: _year.max,
        onChange: function (id, val) {
          $timeout.cancel(dateTimeout);
          dateTimeout = $timeout(PrepareObjects, 1000);
        }
      }
    };

    var datasModal = $modal({scope: $scope, templateUrl: $scope.vm.templates.datas, show: false, onBeforeHide: onBeforeHideDatas });

    var enterValue               = { en: 'Enter the value', ru: 'Введите значение' };
    var confirmDelete            = { en: 'Are you sure you want to delete?', ru: 'Вы действительно хотите удалить?' };

    $scope.vm.onSelectIndicator           = onSelectIndicator;
    $scope.vm.onCreateIndicator           = onCreateIndicator;
    $scope.vm.onUpdateIndicator           = onUpdateIndicator;
    $scope.vm.onDeleteIndicator           = onDeleteIndicator;
    $scope.vm.onSaveIndicator             = onSaveIndicator;
    $scope.vm.onBeforeShowDatas           = onBeforeShowDatas;
    $scope.vm.onGetSelectedIndicator      = onGetSelectedIndicator;
    $scope.vm.onDataSet                   = onDataSet;
    $scope.vm.onIntervalYear              = onIntervalYear;
    $scope.vm.onIntervalClear             = onIntervalClear;
    $scope.vm.onExport                    = onExport;

    $rootScope.$on('onImport', onImport);
    $scope.$watch('vm.selection.rayon', function() { FetchDatas(); });
    $scope.$watch('vm.selection.indicator', function() { FetchDatas(); PrepareObjects(); });

    /* Geting data from API */

    function Login (user, $hide) {
      var callback = function (response) {
        if (response && response.success) {
          $scope.vm.login = true;
          $hide();
        }
      };

      Query.POST(API.Login, user).then(callback);
    };

    function FetchIndicators () {
      var callback = function (response) {
        $scope.vm.indicators = response;
        $scope.vm.modals.indicatorLoading = false;
        if (response.length > 0) $scope.vm.selection.indicator = response[0].id;
      };

      $scope.vm.modals.indicatorLoading = true;
      Query.GET(API.Indicators).then(callback);
    };

    function FetchDatas () {
      var attrs = ['rayon', 'indicator'];
      if (!checkSelections(attrs)) return false;

      var callback = function (response) {
        $scope.vm.datas = [];

        for (var i = _year.min; i <= _year.max; i++) {
          var data = {
            indicator_id: $scope.vm.selection.indicator,
            rayon_id: $scope.vm.selection.rayon,
            year: i,
            val: 0
          };
          response.map(function (rec) {
            if (rec.year == i) data = rec;
          });
          $scope.vm.datas.push(data);
        }

        $scope.vm.modals.dataLoading = false;
      };

      $scope.vm.modals.dataLoading = true;
      Query.GET(API.Datas + '&' + getParams(attrs).join('&')).then(callback);
    };

    function FetchResults (cb) {
      var attrs = ['indicator', 'year'];
      if (!checkSelections(attrs)) return false;
      var callback = function (response) {
        $scope.vm.results = {};
        var maximums = [];
        response.map(function (rec) {
          var val = parseFloat(rec.val || 0);
          if (!isFinite(val)) val = 0;
          $scope.vm.results[rec.rayon_id] = val;
          maximums.push(val);
        });
        $scope.vm.results.max = maximums.max();
        if (!isFinite($scope.vm.results.max)) $scope.vm.results.max = 0;
        cb();
      };

      Query.GET(API.Datas + '&' + getParams(attrs).join('&')).then(callback);
    };

    function onDataSet (data) {
      var val = prompt(enterValue[window.language], data.val || '0');
      if (!val) return false;
      val = parseFloat(val.replace(',', '.'));
      if (!Number.isNaN(val)) {
        var callback = function (response) {
          $scope.vm.modals.dataLoading = false;
        };
        data.val = val;
        if (!checkSelections(['rayon', 'indicator'])) return false;
        $scope.vm.modals.dataLoading = true;
        Query.POST(API.DataSet, data).then(callback);
      }
    };

    function onImport (e, data) {

      var callback = function (response) {
        $scope.vm.modals.dataLoading = false;
        $scope.vm.imported = response;
      };
      var err = function () {
        $scope.vm.modals.dataLoading = false;
      };
      $scope.vm.modals.dataLoading = true;
      Query.POST(API.DataImport, data).then(callback, err);

    };

    function checkSelections (attrs) {
      for (var i = 0; i <= attrs.length - 1; i++) {
        if (!parseInt($scope.vm.selection[attrs[i]])) {
          return false;
          break;
        }
      }
      return true;
    };

    function getParams (attrs) {
      var results = [];
      attrs.map(function (a) {
        if ($scope.vm.selection[a]) results.push(a + '=' + $scope.vm.selection[a]);
      });
      return results;
    };

    function onObjectEvent (e) {
      onBeforeShowDatas(rayons[e.get('objectId')].rayon_id);
    };

    function afterInit (map) {
      _map = map;
      _map.controls.remove('searchControl');
      _map.controls.remove('trafficControl');
      _map.controls.remove('fullscreenControl');
      _objectManager = new ymaps.ObjectManager({
        clusterize: false,
        geoObjectOpenBalloonOnClick: false,
        clusterOpenBalloonOnClick: false
      });
      _objectManager.objects.events.add(['click'], onObjectEvent);
      _map.geoObjects.add(_objectManager);
      PrepareObjects();
    };

    function PrepareObjects () {
      if (!_objectManager) return false;
      _objectManager.removeAll();
      FetchResults(function () {
        $scope.vm.polygons = [];
        rayons.map(function (o, i) {
          var ratio = 1 - ($scope.vm.results[o.rayon_id] || 1) / $scope.vm.results.max;
          if (!isFinite(ratio)) ratio = 1;
          $scope.vm.polygons.push({
            type: 'Feature',
            id: i,
            options: {"fillColor": GetShadeColor(onGetSelectedIndicator('color'), ratio), "strokeColor": "#ccc"},
            properties: {"hintContent": o.oblast + ', ' + o.rayon + ': ' + ($scope.vm.results[o.rayon_id] || 0) + ' ' + onGetSelectedIndicator('measure')},
            geometry: {
              type: 'Polygon',
              coordinates: [JSON.parse(o.geometry)]
            },
          });
        });

        _objectManager.add($scope.vm.polygons);
      });
    };

    function onSelectIndicator (indicator) {
      $scope.vm.selection.indicator = indicator.id;
    };

    function onCreateIndicator () {
      $scope.vm.form.indicator = {};
      $scope.vm.modals.indicator = 'form';
    };

    function onUpdateIndicator (indicator) {
      $scope.vm.form.indicator = {
        id: indicator.id,
        name_ru: indicator.name_ru,
        name_en: indicator.name_en,
        measure_ru: indicator.measure_ru,
        measure_en: indicator.measure_en,
        color: indicator.color
      };
      $scope.vm.modals.indicator = 'form';
    };

    function onDeleteIndicator (indicator, $index) {
      var callback = function (response) {
        $scope.vm.indicators.splice($index, 1);
        $scope.vm.modals.indicatorLoading = false;
      };
      $scope.vm.modals.indicatorLoading = true;
      Query.POST(API.IndicatorDelete + '&id=' + indicator.id).then(callback);
    };

    function onSaveIndicator (indicator) {
      var callback = function (response) {
        if (!indicator.id) $scope.vm.indicators.push(response);
        if (indicator.id) $scope.vm.indicators = $scope.vm.indicators.map(function (o) {
          if (o.id == indicator.id) o = response;
          return o;
        });
        $scope.vm.modals.indicator = 'list';
        $scope.vm.modals.indicatorLoading = false;
        PrepareObjects();
      };

      $scope.vm.modals.indicatorLoading = true;
      Query.POST(API.IndicatorSave, indicator).then(callback);
    };

    function onBeforeShowDatas (rayon_id) {
      $scope.vm.imported = [];
      $scope.vm.selection.rayon = rayon_id || '';
      datasModal.$promise.then(datasModal.show);
    };

    function onBeforeHideDatas () {
      PrepareObjects();
    };

    function onGetSelectedIndicator (attr) {
      var result = '';
      if (!attr) attr = 'name';
      $scope.vm.indicators.map(function (rec) {
        if (rec.id == $scope.vm.selection.indicator) result = rec[attr];
      });
      return result;
    };

    function onIntervalYear () {
      onIntervalClear();
      $scope.vm.yearInterval = true;
      $scope.vm.yearInterval = $interval(function () {
        if ($scope.vm.selection.year < _year.max) $scope.vm.selection.year += 1;
        if ($scope.vm.selection.year == _year.max) $scope.vm.selection.year = _year.min;
        PrepareObjects();
      }, 2000);
    };

    function onIntervalClear () {
      $interval.cancel($scope.vm.yearInterval);
      $scope.vm.yearInterval = false;
    };

    function onExport (data) {
      var wb = XLSX.utils.book_new();
      wb.SheetNames.push('Export');
      var ws = XLSX.utils.json_to_sheet(data);
      wb.Sheets['Export'] = ws;
      var wbout = XLSX.write(wb, {bookType: 'xlsx', type: 'binary'});
      function s2ab (s) {
        var buff = new ArrayBuffer(s.length);
        var view = new Uint8Array(buff);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buff;
      }
      saveAs(new Blob([s2ab(wbout)], {type: 'application/octet-stream'}), 'export.xlsx');
    };

    function onInit () {
      FetchIndicators();
    };

    function GetShadeColor (color, percent) {
      var f = parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
      return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
    };

    onInit();

  };

})();
