(function () {
  'use strict';

  /* Register using app classes */
  var app = angular.module('app', [
    'ngSanitize',
    'ngAnimate',
    'mgcrea.ngStrap',
    'yaMap',
    'rzModule',

    'app.config',
    'factory.query',
    'controller.main',
    'directive.importXls'

  ]);
})();