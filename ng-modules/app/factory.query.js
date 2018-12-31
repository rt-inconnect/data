(function () {
  'use strict';

  angular
  .module('factory.query', [])
  .factory('Query', ['$http', '$q', QueryFactory]);

  function QueryFactory ($http, $q) {

    var factory = {
      GET: GET,
      POST: POST
    };

    return factory;

    /* Helper for GET Request to the API */
    function GET (url, callback) {
      var defer = $q.defer();
      $http.get(url).then(function(res) {
        if (typeof callback == 'function') callback(res);
        defer.resolve(res.data);
      });
      return defer.promise;
    };

    /* Helper for POST Request to the API */
    function POST (url, data, callback) {
      var defer = $q.defer();
      $http.post(url, data).then(function(res) {
        if (typeof callback == 'function') callback(res);
        defer.resolve(res.data);
      }, function(res) {
        defer.reject(res.data);
      });
      return defer.promise;
    };

  };
})();