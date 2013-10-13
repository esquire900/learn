# function processes the mindmap, triggered in every event done in the mindmap
processMindMap = (d, selected) ->
	e = document.getElementById("mmCtrl")
	scope = angular.element(e).scope()

	scope.mmArray = d
	# different node slected, update MindMapCtrl
	scope.selected = selected.id
	scope.selectedType = 'tied'
	# update $scope.mems array
	if typeof scope.mems[selected.id] is "undefined"
		scope.mems[selected.id] = {
			term: selected.text.caption
			mem: ' '
			answer: ' '
		}
	scope.mems[selected.id].term = selected.text.caption
	scope.saveButton = 'unsaved'
	scope.savingText = 'Save me!'
	scope.$apply()
	scope.update()
	scope.$apply()
	return 0


deleteNode = (id) ->
	e = document.getElementById("mmCtrl")
	scope = angular.element(e).scope()
	delete scope.mems[id]
	scope.$apply()
	# console.log scope.mems
	return 0


MindMapCtrl = ($scope) ->
	$scope.mems = {}
	$scope.selected = ''
	$scope.mmArray = []
	$scope.saveButton = 'normal'
	$scope.savingText = 'Save'
	$scope.redReady = 0
	$scope.untiedMems = {}
	$scope.countUntiedId = 0

	$scope.show = []
	$scope.show.mindmap = false
	$scope.show.settings = false
	$scope.show.loading = true
	$scope.show.toolbar = true
	$scope.show.memcontainer = true
	$scope.show.untiedmemcontainer = true
	$scope.show.helpcontainer = true

	$scope.setting = {
		date: '12-12-2015'
		infinite: 0
		target: 0
		algoritm: 1
		file: 1
	}

	$scope.redactorInit = () ->

		$scope.$apply()
		$scope.redReady++
		
	$scope.update = () ->
		$scope.answer = $scope.mems[$scope.selected].answer
		$scope.mem = $scope.mems[$scope.selected].mem
		$scope.term = $scope.mems[$scope.selected].term
		# needed to work out some ugly bug 
		if $scope.redReady >= 2
			if $scope.mem isnt null
				$('#mem').redactor('set', $scope.mem)
			if $scope.answer isnt null
				$('#answera').redactor('set', $scope.answer)
		null

	

	$scope.updateArray = () ->
		if $scope.redReady >= 2
			if $('#mem').redactor('get') is "<p><span style='color:#BBB;'>Mem</span></p><br>"
				$('#mem').redactor('set','')
			else
		    	$scope.mems[$scope.selected].mem = $('#mem').redactor('get')

		    if $('#answera').redactor('get') is "<p><span style='color:#BBB;'>Answer</span></p><br>"
		    	$('#answera').redactor('set','')
		    else
		    	$scope.mems[$scope.selected].answer = $('#answera').redactor('get')
		    
		return 0

	$scope.sendData = () ->
		mm = $scope.mmArray
		mm = mm.serialize()
		mems = $scope.mems
		mems = JSON.stringify(mems)
		untiedmems = JSON.stringify($scope.untiedMems)
		settings = JSON.stringify($scope.setting)
		# console.log $scope.mems.length
		
		$scope.savingText = "saving.."

		data = {}
		data.mindmap = mm
		data.mindmapItems = mems
		data.settings = settings
		url = "../API/saveMindMap"

		$.ajax
			url: url
			type: "POST"
			data: data
			success: (datar) ->
				if datar.success is true
					$scope.saveButton = 'saved'
					$scope.savingText = 'done!'
					$scope.$apply()
				else
					$scope.debug += datar
				$scope.$apply()
			error: (datar) ->
				$scope.debug += JSON.stringify(datar)
				$scope.$apply()

		return 0

	$scope.openSettings = () ->
		$scope.show.mindmap = false
		$scope.show.settings = true


	$scope.hideSettings = () ->
		$scope.show.mindmap = true
		$scope.show.settings = false


	$scope.init = () ->
		href = window.location.href.split("/mindmap/")
		id = href[1]
		if id isnt null
			url = "../API/getItems?id="+ id
			$.getJSON url, (data) ->
				if data.success is false
					console.log data.message + "false"
					return 0
				data = data.data
				for key of data
					obj = data[key]
					$scope.mems[key] = {
						mem: obj.mem
						term: obj.term
						answer: obj.answer
					}
			url = "../API/getSettings?id="+ id
			$.getJSON url, (data) ->
				if data.success is false
					console.log data.message + "false"
					return 0
				data = data.data
				console.log "settings loaded"
				
				$scope.setting = {
					date: data.settings.date
					infinite: data.settings.infinite
					target: data.settings.target_percentage
					algoritm: data.settings.algoritm
					file: data.settings.detail_file
				}
				$scope.show.mindmap = true
				$scope.show.settings = false
				$scope.show.loading = false
				$scope.show.toolbar = true
				console.log $scope.mems
				$scope.$apply()
			
		else
			console.log "No id was set"

	$scope.init()
	# saves data when user leaves page
	
	alert = false
	$(window).on "beforeunload", ->
		if(scope.saveButton is 'unsaved')
			$scope.sendData()
			if(alert is true)
				return 0
		
	return 0
 
