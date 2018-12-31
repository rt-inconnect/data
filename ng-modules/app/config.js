(function () {
  'use strict';

  /* Constants and Configs that used on the frontend */
  angular
  .module  ('app.config',   []     )
  .constant('API',          API()  )
  .constant('MONTH',        MONTH());

  /* URLs to Backend API */
  function API () {

    var prefix = '/data/index.php';

    var language = '?language=' + window.language;

    return {

      GeoJSON                 : '/data/uzb_ry.geojson',
      Login                   : prefix + '/api/login',

      Rayons                  : prefix + '/api/rayons'              + language,

      Indicators              : prefix + '/api/indicators'          + language,
      IndicatorSave           : prefix + '/api/indicatorSave'       + language,
      IndicatorDelete         : prefix + '/api/indicatorDelete'     + language,

      Datas                   : prefix + '/api/datas'               + language,
      DataSet                 : prefix + '/api/dataSet'             + language,
      DataImport              : prefix + '/api/dataImport'          + language,

      Templates               : prefix + '/site/templates'          + language + '&template='

    };

  };

  function MONTH () {
    return {
      en: {
        1  : "Jan",
        2  : "Feb",
        3  : "Mar",
        4  : "Apr",
        5  : "May",
        6  : "Jun",
        7  : "Jul",
        8  : "Aug",
        9  : "Sep",
        10 : "Oct",
        11 : "Nov",
        12 : "Dec"
      },
      ru: {
        1  : "Янв",
        2  : "Фев",
        3  : "Мар",
        4  : "Апр",
        5  : "Май",
        6  : "Июн",
        7  : "Июл",
        8  : "Авг",
        9  : "Сен",
        10 : "Окт",
        11 : "Ноя",
        12 : "Дек"
      }
    };
  };

})();
