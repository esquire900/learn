angular.module('practiceApp',['ngSanitize']) 

PracticeCtrl = ($scope) ->
	$scope.elements = []
	$scope.alert = []
	$scope.question = []
	$scope.answer = []
	$scope.mem = []

	$(document).on 'keypress', (e) =>
		if $scope.show.answer is true or $scope.show.writeAnswer is true
			if e.which is 49
				$scope.evaluate(1)
				$scope.$apply()
			if e.which is 50
				$scope.evaluate(2)
				$scope.$apply()
			if e.which is 51
				$scope.evaluate(3)
				$scope.$apply()
		else
			if e.which is 13
				$scope.showAnswer()
				$scope.$apply()
			if e.which is 48
				$scope.showMem()
				$scope.$apply()

	$scope.loadQuestions = () ->
		$scope.id = ~~window.location.search.replace("?id=",'')

		if typeof $scope.id isnt "number" or $scope.id is 0
			$scope.notify('No id is set in the url, you sure you came here the right way?', 'info')
			return 0

		url = "API/getQuestions?id="+$scope.id
		$.getJSON url, (data) ->
			if data.success is false
				$scope.notify data.message, 'danger'
			else
				$scope.elements = data.data
				if data.data.length is 0
					$scope.notify "Nothing to practice here (yet)!", 'info'
				else
					$scope.newQuestion()
					$scope.log('document.practice_session_start', null, $scope.id)
					$scope.show.question = true
					$scope.show.loading = false
			$scope.$apply()

	$scope.notify = (message, style) ->
		$scope.show.alert = true
		$scope.alert.message = message
		$scope.alert.style = 'alert alert-dismissable alert-'+style

	$scope.newQuestion = () ->
		# select the next question

		if $scope.elements[0] is undefined
			#user is done
			$scope.log('document.practice_session_done', null, $scope.id)
			$scope.show.question = false
			$scope.show.done = true
			$scope.updatePracticeTimes()

		q = $scope.elements[0].questions[0]
		$scope.question.text = q.question
		$scope.question.path = ''
		rev = Math.floor(Math.random()*10) 
		for e in q.line
			if _i isnt 0 
				$scope.question.path += " - "
			if _i is 0 and rev > 5 and q.reverseAnswer is true
				$scope.question.path += ''
			else
				$scope.question.path += e

		$scope.answer.text = q.answer
		$scope.mem.text = q.mem
		if q.reverseAnswer is true and rev > 5
			$scope.question.text = q.answer
			$scope.answer.text = q.question
			$scope.question.path += "  {reversed}"
		$scope.log('mem.show_question', null, $scope.elements[0].id)			

		if q.questionMethod is "think" #user is supposed to think about answer
			$scope.hideAll()
			$scope.show.buttonsQuestion = true
			$scope.show.question = true
		else if q.questionMethod is "write"
			$scope.hideAll()
			$scope.show.question = true
			$scope.show.writeField = true
			$("#txtField").focus()
		return 0

	$scope.showAnswer = () ->
		$scope.hideAll()
		$scope.show.answer = true
		$scope.show.question = true
		$scope.show.buttonsEval = true
		$scope.log('mem.show_answer', null, $scope.elements[0].id)

	$scope.showWriteAnswer = () ->
		$scope.showAnswer()
		$scope.show.answer = false
		$scope.show.question = true
		$scope.show.buttonsEval = true
		$scope.show.writeAnswer = true

	$scope.showMem = () ->
		$scope.mem.show = true
		$scope.log('mem.show_mem', null, $scope.elements[0].id)

	$scope.evaluate = (score) ->
		time = new Date().getTime() / 1000
		e = $scope.elements[0]
		if 	e.results is undefined
			e.results = []
		if score is 1
			#question was right, we don't have to answer it anymore			
			$scope.log('mem.evaluate', 1, e.id)
			$scope.elements.shift() # removes the current question, as it was answered corrctly
		if score is 2
			#question almost right
			$scope.log('mem.evaluate', 2, e.id)
			if($scope.elements.length > 5)
				$scope.elements.splice(4, 0, $scope.elements.shift())
			else
				$scope.elements[$scope.elements.length - 1] = $scope.elements.shift() #shift question to end of array
		if score is 3
			#question almost wrong
			$scope.log('mem.evaluate', 3, e.id)
			if($scope.elements.length > 5)
				$scope.elements.splice(4, 0, $scope.elements.shift())
			else
				$scope.elements[$scope.elements.length - 1] = $scope.elements.shift() #shift question to end of array
		$scope.newQuestion()

	$scope.hideAll = () ->
		$scope.show = {
			alert: false
			question: false
			loading: false
			done: false
			buttonsEval: false
			buttonsQuestion: false
			writeField: false
			writeAnswer: false
		}
		
	$scope.hideAll()
	$scope.show.loading = true
	#actionLog($action, $target, $target_id, $timestamp){
	#target is additional information
	$scope.log = (action, target, target_id) ->
		time = new Date().getTime() / 1000
		url = "API/log?action="+action
		url += "&target="+target
		url += "&target_id="+target_id
		url += "&timestamp="+time

		$.ajax
			url:url 
			type: "POST"

		return 0

	$scope.updatePracticeTimes = () ->
		$.ajax
			url:"API/updatePracticeTimes?id="+$scope.id 
			type: "POST"
	    
	$scope.loadQuestions()
