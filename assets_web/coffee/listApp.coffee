ListCtrl = ($scope) ->
	$scope.mems = {}
	$scope.selected = ''
	$scope.saveButton = 'normal'
	$scope.savingText = 'Save'
	$scope.redReady = 0
	$scope.items = {}
	$scope.countItemId = 0

	$scope.show = []
	$scope.show.settings = false
	$scope.show.loading = true
	$scope.show.itemContainer = true

	$scope.setting = {
		date: '12-12-2015'
		infinite: 0
		target: 0
		algoritm: 1
		file: 1
	}

	$scope.redactorInit = () ->
		$scope.redReady++
		
	$scope.update = () ->
		$scope.mem = $scope.items[$scope.selected].mem
		$scope.term = $scope.items[$scope.selected].term
		$scope.answer = $scope.items[$scope.selected].answer
		# needed to work out some ugly bug 
		if $scope.redReady >= 2
			$('#mem').redactor('set', $scope.items[$scope.selected].mem)
			$('#answera').redactor('set', $scope.answer)
	$scope.updateArray = () ->

		$scope.items[$scope.selected].term = $scope.term
		$scope.items[$scope.selected].mem = $('#mem').redactor('get')
		$scope.items[$scope.selected].answer = $('#answera').redactor('get')
		return 0

	$scope.sendData = () ->
		items = JSON.stringify($scope.items)
		settings = JSON.stringify($scope.setting)
		# console.log $scope.mems.length
		
		$scope.savingText = "saving.."

		data = {}
		data.items = items 
		data.settings = settings
		url = "API/saveMindMap"

		$.ajax
			url: url
			type: "POST"
			data: data
			success: (datar) ->
				if datar.success is true
					$scope.saveButton = 'saved'
					$scope.savingText = 'done!'
					$scope.$apply()
				$scope.debug += "<br>"+ datar
				$scope.$apply()
			error: (datar) ->
				$scope.debug += JSON.stringify(datar)
				$scope.$apply()
			
		$scope.debug += "<br>"+ JSON.stringify(data)
		return 0

	$scope.createItem = () ->
		if $scope.newItem == '' or $scope.newItem is undefined
			return 0
		$scope.untiedMems[$scope.countItemId] = {
			term: $scope.newItem
			mem: ''
			answer: ''
			id: $scope.countItemId
			new: true
		}
		$scope.selectUntied($scope.countItemId)
		$scope.countItemId++
		$scope.newItem = ''
		
	$scope.openSettings = () ->
		$scope.show.itemContainer = false
		$scope.show.settings = true

	$scope.selectItem = (id) ->
		$scope.selected = id
		$scope.update()

	$scope.delItem = (id) ->
		delete $scope.items[id]

	$scope.init = () ->
		result = new RegExp("[\\?&]id=([^&#]*)").exec(window.location.href)
		if result isnt null

			url = "API/getSettings?id="+ window.location.search.replace "?id=", ""
			$.getJSON url, (data) ->
				if data.success is false
					console.log data.message + "false"
					return 0
				data = data.data
				console.log data
				
				$scope.setting = {
					date: data.settings.date
					infinite: data.settings.infinite
					target: data.settings.target_percentage
					algoritm: data.settings.algoritm
					file: data.settings.detail_file
				}
			url = "API/getUntiedMems?id="+ window.location.search.replace "?id=", ""
			$.getJSON url, (data) ->
				if data.success is false
					console.log data.message + "false"
					return 0
				data = data.data
				for key of data
					obj = data[key]
					$scope.items[key] = {
						id: key
						new: false
						mem: obj.mem
						term: obj.term
						answer: obj.answer
					}
				$scope.show.itemContainer = true
				$scope.show.settings = false
				$scope.show.loading = false
				$scope.$apply()
		else
			$scope.show.itemContainer = true
			$scope.show.settings = false
			$scope.show.loading = false

	$scope.init()