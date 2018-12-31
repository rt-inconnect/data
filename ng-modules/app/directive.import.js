(function () {
  'use strict';

  angular
  .module('directive.importXls', [])
  .directive('importXls', ['$rootScope', importXls]);

  function importXls ($rootScope) {
    var directive = {
      link: link,
      scope: { opts: '=' }
    };

    return directive;

    function link ($scope, $el) {
      $el.on('change', function (changeEvent) {
        var reader = new FileReader();
        reader.onload = function (e) {
          var bstr = e.target.result;
          var workbook = XLSX.read(bstr, {type:'binary'});
          workbook.SheetNames.forEach(function(sheetName) {
            var results = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            $rootScope.$broadcast('onImport', results);
          });
        };

        reader.readAsBinaryString(changeEvent.target.files[0]);
      });
    };
  };

})();