var ListCtrl;

ListCtrl = function($scope) {
  $scope.mems = {};
  $scope.selected = '';
  $scope.saveButton = 'normal';
  $scope.savingText = 'Save';
  $scope.redReady = 0;
  $scope.items = {};
  $scope.countItemId = 0;
  $scope.show = [];
  $scope.show.settings = false;
  $scope.show.loading = true;
  $scope.show.itemContainer = true;
  $scope.setting = {
    date: '12-12-2015',
    infinite: 0,
    target: 0,
    algoritm: 1,
    file: 1
  };
  $scope.redactorInit = function() {
    return $scope.redReady++;
  };
  $scope.update = function() {
    $scope.mem = $scope.items[$scope.selected].mem;
    $scope.term = $scope.items[$scope.selected].term;
    $scope.answer = $scope.items[$scope.selected].answer;
    if ($scope.redReady >= 2) {
      $('#mem').redactor('set', $scope.items[$scope.selected].mem);
      return $('#answera').redactor('set', $scope.answer);
    }
  };
  $scope.updateArray = function() {
    $scope.items[$scope.selected].term = $scope.term;
    $scope.items[$scope.selected].mem = $('#mem').redactor('get');
    $scope.items[$scope.selected].answer = $('#answera').redactor('get');
    return 0;
  };
  $scope.sendData = function() {
    var data, items, settings, url;
    items = JSON.stringify($scope.items);
    settings = JSON.stringify($scope.setting);
    $scope.savingText = "saving..";
    data = {};
    data.items = items;
    data.settings = settings;
    url = "API/saveMindMap";
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      success: function(datar) {
        if (datar.success === true) {
          $scope.saveButton = 'saved';
          $scope.savingText = 'done!';
          $scope.$apply();
        }
        $scope.debug += "<br>" + datar;
        return $scope.$apply();
      },
      error: function(datar) {
        $scope.debug += JSON.stringify(datar);
        return $scope.$apply();
      }
    });
    $scope.debug += "<br>" + JSON.stringify(data);
    return 0;
  };
  $scope.createItem = function() {
    if ($scope.newItem === '' || $scope.newItem === void 0) {
      return 0;
    }
    $scope.untiedMems[$scope.countItemId] = {
      term: $scope.newItem,
      mem: '',
      answer: '',
      id: $scope.countItemId,
      "new": true
    };
    $scope.selectUntied($scope.countItemId);
    $scope.countItemId++;
    return $scope.newItem = '';
  };
  $scope.openSettings = function() {
    $scope.show.itemContainer = false;
    return $scope.show.settings = true;
  };
  $scope.selectItem = function(id) {
    $scope.selected = id;
    return $scope.update();
  };
  $scope.delItem = function(id) {
    return delete $scope.items[id];
  };
  $scope.init = function() {
    var result, url;
    result = new RegExp("[\\?&]id=([^&#]*)").exec(window.location.href);
    if (result !== null) {
      url = "API/getSettings?id=" + window.location.search.replace("?id=", "");
      $.getJSON(url, function(data) {
        if (data.success === false) {
          console.log(data.message + "false");
          return 0;
        }
        data = data.data;
        console.log(data);
        return $scope.setting = {
          date: data.settings.date,
          infinite: data.settings.infinite,
          target: data.settings.target_percentage,
          algoritm: data.settings.algoritm,
          file: data.settings.detail_file
        };
      });
      url = "API/getUntiedMems?id=" + window.location.search.replace("?id=", "");
      return $.getJSON(url, function(data) {
        var key, obj;
        if (data.success === false) {
          console.log(data.message + "false");
          return 0;
        }
        data = data.data;
        for (key in data) {
          obj = data[key];
          $scope.items[key] = {
            id: key,
            "new": false,
            mem: obj.mem,
            term: obj.term,
            answer: obj.answer
          };
        }
        $scope.show.itemContainer = true;
        $scope.show.settings = false;
        $scope.show.loading = false;
        return $scope.$apply();
      });
    } else {
      $scope.show.itemContainer = true;
      $scope.show.settings = false;
      return $scope.show.loading = false;
    }
  };
  return $scope.init();
};
