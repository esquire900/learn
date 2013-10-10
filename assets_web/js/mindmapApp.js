var MindMapCtrl, deleteNode, processMindMap;

processMindMap = function(d, selected) {
  var e, scope;
  e = document.getElementById("mmCtrl");
  scope = angular.element(e).scope();
  scope.mmArray = d;
  scope.selected = selected.id;
  scope.selectedType = 'tied';
  if (typeof scope.mems[selected.id] === "undefined") {
    scope.mems[selected.id] = {
      term: selected.text.caption,
      mem: ' ',
      answer: ' '
    };
  }
  scope.mems[selected.id].term = selected.text.caption;
  scope.saveButton = 'unsaved';
  scope.savingText = 'Save';
  scope.$apply();
  scope.update();
  scope.$apply();
  return 0;
};

deleteNode = function(id) {
  var e, scope;
  e = document.getElementById("mmCtrl");
  scope = angular.element(e).scope();
  delete scope.mems[id];
  scope.$apply();
  return 0;
};

MindMapCtrl = function($scope) {
  $scope.mems = {};
  $scope.selected = '';
  $scope.selectedType = '';
  $scope.mmArray = [];
  $scope.saveButton = 'normal';
  $scope.savingText = 'Save';
  $scope.redReady = 0;
  $scope.untiedMems = {};
  $scope.countUntiedId = 0;
  $scope.show = [];
  $scope.show.mindmap = false;
  $scope.show.settings = false;
  $scope.show.loading = true;
  $scope.show.toolbar = true;
  $scope.show.memcontainer = true;
  $scope.show.untiedmemcontainer = true;
  $scope.show.helpcontainer = true;
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
    if ($scope.selectedType === 'tied') {
      $scope.answer = $scope.mems[$scope.selected].answer;
      $scope.mem = $scope.mems[$scope.selected].mem;
      $scope.term = $scope.mems[$scope.selected].term;
      if ($scope.redReady >= 2) {
        $('#mem').redactor('set', $scope.mem);
        $('#answera').redactor('set', $scope.answer);
      }
    }
    if ($scope.selectedType === 'untied') {
      $scope.mem = $scope.untiedMems[$scope.selected].mem;
      $scope.term = $scope.untiedMems[$scope.selected].term;
      $scope.answer = $scope.untiedMems[$scope.selected].answer;
      if ($scope.redReady >= 2) {
        $('#mem').redactor('set', $scope.untiedMems[$scope.selected].mem);
        return $('#answera').redactor('set', $scope.answer);
      }
    }
  };
  $scope.updateArray = function() {
    if ($scope.selectedType === 'tied') {
      $scope.mems[$scope.selected].mem = $('#mem').redactor('get');
      $scope.mems[$scope.selected].answer = $('#answera').redactor('get');
    }
    if ($scope.selectedType === 'untied') {
      $scope.untiedMems[$scope.selected].term = $scope.term;
      $scope.untiedMems[$scope.selected].mem = $('#mem').redactor('get');
      $scope.untiedMems[$scope.selected].answer = $('#answera').redactor('get');
    }
    return 0;
  };
  $scope.sendData = function() {
    var data, mems, mm, settings, untiedmems, url;
    mm = $scope.mmArray;
    mm = mm.serialize();
    mems = $scope.mems;
    mems = JSON.stringify(mems);
    untiedmems = JSON.stringify($scope.untiedMems);
    settings = JSON.stringify($scope.setting);
    $scope.savingText = "saving..";
    data = {};
    data.mindmap = mm;
    data.mems = mems;
    data.untiedmems = untiedmems;
    data.settings = settings;
    url = "../API/saveMindMap";
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
  $scope.createUntiedMem = function() {
    if ($scope.newuntied === '' || $scope.newuntied === void 0) {
      return 0;
    }
    $scope.untiedMems[$scope.countUntiedId] = {
      term: $scope.newuntied,
      mem: '',
      answer: '',
      id: $scope.countUntiedId,
      "new": true
    };
    $scope.selectUntied($scope.countUntiedId);
    $scope.countUntiedId++;
    return $scope.newuntied = '';
  };
  $scope.openSettings = function() {
    $scope.show.mindmap = false;
    return $scope.show.settings = true;
  };
  $scope.toggleToolbar = function(name) {
    if ($scope.show[name] === true) {
      $scope.show[name] = false;
    } else {
      $scope.show[name] = true;
    }
    return console.log($scope.show['name']);
  };
  $scope.hideSettings = function() {
    $scope.show.mindmap = true;
    return $scope.show.settings = false;
  };
  $scope.delUntiedMem = function(id) {
    return delete $scope.untiedMems[id];
  };
  $scope.selectUntied = function(id) {
    $scope.selected = id;
    $scope.selectedType = "untied";
    return $scope.update();
  };
  $scope.init = function() {
    var result, url;
    result = new RegExp("[\\?&]id=([^&#]*)").exec(window.location.href);
    if (result !== null) {
      url = "API/getMems?id=" + window.location.search.replace("?id=", "");
      $.getJSON(url, function(data) {
        var key, obj, _results;
        if (data.success === false) {
          console.log(data.message + "false");
          return 0;
        }
        data = data.data;
        _results = [];
        for (key in data) {
          obj = data[key];
          _results.push($scope.mems[key] = {
            mem: obj.mem,
            term: obj.term,
            answer: obj.answer
          });
        }
        return _results;
      });
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
          $scope.untiedMems[key] = {
            id: key,
            "new": false,
            mem: obj.mem,
            term: obj.term,
            answer: obj.answer
          };
        }
        $scope.show.mindmap = true;
        $scope.show.settings = false;
        $scope.show.loading = false;
        $scope.show.toolbar = true;
        return $scope.$apply();
      });
    } else {
      $scope.show.mindmap = true;
      $scope.show.settings = false;
      $scope.show.loading = false;
      return $scope.show.toolbar = true;
    }
  };
  $scope.init();
  return 0;
};
