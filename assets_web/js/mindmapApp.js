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
  scope.savingText = 'Save me!';
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
  var alert;
  $scope.mems = {};
  $scope.selected = '';
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
    $scope.$apply();
    return $scope.redReady++;
  };
  $scope.update = function() {
    $scope.answer = $scope.mems[$scope.selected].answer;
    $scope.mem = $scope.mems[$scope.selected].mem;
    $scope.term = $scope.mems[$scope.selected].term;
    if ($scope.redReady >= 2) {
      if ($scope.mem !== null) {
        $('#mem').redactor('set', $scope.mem);
      }
      if ($scope.answer !== null) {
        $('#answera').redactor('set', $scope.answer);
      }
    }
    return null;
  };
  $scope.updateArray = function() {
    if ($scope.redReady >= 2) {
      if ($('#mem').redactor('get') === "<p><span style='color:#BBB;'>Mem</span></p><br>") {
        $('#mem').redactor('set', '');
      } else {
        $scope.mems[$scope.selected].mem = $('#mem').redactor('get');
      }
      if ($('#answera').redactor('get') === "<p><span style='color:#BBB;'>Answer</span></p><br>") {
        $('#answera').redactor('set', '');
      } else {
        $scope.mems[$scope.selected].answer = $('#answera').redactor('get');
      }
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
    data.mindmapItems = mems;
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
        } else {
          $scope.debug += datar;
        }
        return $scope.$apply();
      },
      error: function(datar) {
        $scope.debug += JSON.stringify(datar);
        return $scope.$apply();
      }
    });
    return 0;
  };
  $scope.openSettings = function() {
    $scope.show.mindmap = false;
    return $scope.show.settings = true;
  };
  $scope.hideSettings = function() {
    $scope.show.mindmap = true;
    return $scope.show.settings = false;
  };
  $scope.init = function() {
    var href, id, url;
    href = window.location.href.split("/mindmap/");
    id = href[1];
    if (id !== null) {
      url = "../API/getItems?id=" + id;
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
      url = "../API/getSettings?id=" + id;
      return $.getJSON(url, function(data) {
        if (data.success === false) {
          console.log(data.message + "false");
          return 0;
        }
        data = data.data;
        console.log("settings loaded");
        $scope.setting = {
          date: data.settings.date,
          infinite: data.settings.infinite,
          target: data.settings.target_percentage,
          algoritm: data.settings.algoritm,
          file: data.settings.detail_file
        };
        $scope.show.mindmap = true;
        $scope.show.settings = false;
        $scope.show.loading = false;
        $scope.show.toolbar = true;
        console.log($scope.mems);
        return $scope.$apply();
      });
    } else {
      return console.log("No id was set");
    }
  };
  $scope.init();
  alert = false;
  $(window).on("beforeunload", function() {
    if (scope.saveButton === 'unsaved') {
      $scope.sendData();
      if (alert === true) {
        return 0;
      }
    }
  });
  return 0;
};
