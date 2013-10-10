var PracticeCtrl;

angular.module('practiceApp', ['ngSanitize']);

PracticeCtrl = function($scope) {
  var _this = this;
  $scope.elements = [];
  $scope.alert = [];
  $scope.question = [];
  $scope.answer = [];
  $scope.mem = [];
  $(document).on('keypress', function(e) {
    if ($scope.show.answer === true || $scope.show.writeAnswer === true) {
      if (e.which === 49) {
        $scope.evaluate(1);
        $scope.$apply();
      }
      if (e.which === 50) {
        $scope.evaluate(2);
        $scope.$apply();
      }
      if (e.which === 51) {
        $scope.evaluate(3);
        return $scope.$apply();
      }
    } else {
      if (e.which === 13) {
        $scope.showAnswer();
        $scope.$apply();
      }
      if (e.which === 48) {
        $scope.showMem();
        return $scope.$apply();
      }
    }
  });
  $scope.loadQuestions = function() {
    var url;
    $scope.id = ~~window.location.search.replace("?id=", '');
    if (typeof $scope.id !== "number" || $scope.id === 0) {
      $scope.notify('No id is set in the url, you sure you came here the right way?', 'info');
      return 0;
    }
    url = "API/getQuestions?id=" + $scope.id;
    return $.getJSON(url, function(data) {
      if (data.success === false) {
        $scope.notify(data.message, 'danger');
      } else {
        $scope.elements = data.data;
        if (data.data.length === 0) {
          $scope.notify("Nothing to practice here (yet)!", 'info');
        } else {
          $scope.newQuestion();
          $scope.log('document.practice_session_start', null, $scope.id);
          $scope.show.question = true;
          $scope.show.loading = false;
        }
      }
      return $scope.$apply();
    });
  };
  $scope.notify = function(message, style) {
    $scope.show.alert = true;
    $scope.alert.message = message;
    return $scope.alert.style = 'alert alert-dismissable alert-' + style;
  };
  $scope.newQuestion = function() {
    var e, q, rev, _i, _len, _ref;
    if ($scope.elements[0] === void 0) {
      $scope.log('document.practice_session_done', null, $scope.id);
      $scope.show.question = false;
      $scope.show.done = true;
      $scope.updatePracticeTimes();
    }
    q = $scope.elements[0].questions[0];
    $scope.question.text = q.question;
    $scope.question.path = '';
    rev = Math.floor(Math.random() * 10);
    _ref = q.line;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      e = _ref[_i];
      if (_i !== 0) {
        $scope.question.path += " - ";
      }
      if (_i === 0 && rev > 5 && q.reverseAnswer === true) {
        $scope.question.path += '';
      } else {
        $scope.question.path += e;
      }
    }
    $scope.answer.text = q.answer;
    $scope.mem.text = q.mem;
    if (q.reverseAnswer === true && rev > 5) {
      $scope.question.text = q.answer;
      $scope.answer.text = q.question;
      $scope.question.path += "  {reversed}";
    }
    $scope.log('mem.show_question', null, $scope.elements[0].id);
    if (q.questionMethod === "think") {
      $scope.hideAll();
      $scope.show.buttonsQuestion = true;
      $scope.show.question = true;
    } else if (q.questionMethod === "write") {
      $scope.hideAll();
      $scope.show.question = true;
      $scope.show.writeField = true;
      $("#txtField").focus();
    }
    return 0;
  };
  $scope.showAnswer = function() {
    $scope.hideAll();
    $scope.show.answer = true;
    $scope.show.question = true;
    $scope.show.buttonsEval = true;
    return $scope.log('mem.show_answer', null, $scope.elements[0].id);
  };
  $scope.showWriteAnswer = function() {
    $scope.showAnswer();
    $scope.show.answer = false;
    $scope.show.question = true;
    $scope.show.buttonsEval = true;
    return $scope.show.writeAnswer = true;
  };
  $scope.showMem = function() {
    $scope.mem.show = true;
    return $scope.log('mem.show_mem', null, $scope.elements[0].id);
  };
  $scope.evaluate = function(score) {
    var e, time;
    time = new Date().getTime() / 1000;
    e = $scope.elements[0];
    if (e.results === void 0) {
      e.results = [];
    }
    if (score === 1) {
      $scope.log('mem.evaluate', 1, e.id);
      $scope.elements.shift();
    }
    if (score === 2) {
      $scope.log('mem.evaluate', 2, e.id);
      if ($scope.elements.length > 5) {
        $scope.elements.splice(4, 0, $scope.elements.shift());
      } else {
        $scope.elements[$scope.elements.length - 1] = $scope.elements.shift();
      }
    }
    if (score === 3) {
      $scope.log('mem.evaluate', 3, e.id);
      if ($scope.elements.length > 5) {
        $scope.elements.splice(4, 0, $scope.elements.shift());
      } else {
        $scope.elements[$scope.elements.length - 1] = $scope.elements.shift();
      }
    }
    return $scope.newQuestion();
  };
  $scope.hideAll = function() {
    return $scope.show = {
      alert: false,
      question: false,
      loading: false,
      done: false,
      buttonsEval: false,
      buttonsQuestion: false,
      writeField: false,
      writeAnswer: false
    };
  };
  $scope.hideAll();
  $scope.show.loading = true;
  $scope.log = function(action, target, target_id) {
    var time, url;
    time = new Date().getTime() / 1000;
    url = "API/log?action=" + action;
    url += "&target=" + target;
    url += "&target_id=" + target_id;
    url += "&timestamp=" + time;
    $.ajax({
      url: url,
      type: "POST"
    });
    return 0;
  };
  $scope.updatePracticeTimes = function() {
    return $.ajax({
      url: "API/updatePracticeTimes?id=" + $scope.id,
      type: "POST"
    });
  };
  return $scope.loadQuestions();
};
