<?php Yii::app()->params['bodyBackgroundClass'] = ''; ?>
<div ng-app class="dragcontainer">
	<?php $showMindMapHeader = true; ?>
	<?php Yii::import('ext.redactor.ImperaviRedactorWidget'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery-ui'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/angular.js/1.1.5/angular.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets_web/js/mindmapApp.js'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/mindmap/css/app.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/mindmap/css/minicolors/jquery.miniColors.css'); ?>

	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/css/datepicker.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/js/bootstrap-datepicker.js"); ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
	<div class="row" ng-controller="MindMapCtrl" id="mmCtrl">

		<div ng-show="show.loading" >
			<div style="height:100px"></div>
			<center>loading</center>
		</div>
		<div ng-show="show.toolbar" ng-cloak>
			<div class="col-lg-12" style="padding-top:70px;">
				<center>
					<a href="#" ng-click="toggleToolbar('memcontainer')">
						<button class="btn btn-small">MEMc</button>
					</a>
					<a href="#" ng-click="toggleToolbar('untiedmemcontainer')">
						<button class="btn btn-small">MEMu</button>
					</a>
					<a href="#" ng-click="toggleToolbar('helpcontainer')">
						<button class="btn btn-small">Helper</button>
					</a>
				</center>
			</div>
		</div>
		<div ng-show="show.mindmap" ng-cloak>
			<div class="col-lg-12">
				<?php if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$add = "?id=".$_GET['id'];
				}else{
					$add = '';
				}?>
				<div id="print-area">
				  <p class="print-placeholder">Please use the print option from the
				    mind map menu</p>
				</div>
				<div id="container">
					<div id="canvas-container">
						<div id="drawing-area" class="no-select"></div>
					</div>
				</div>			
			</div>
			
			<div class="memContainer" ng-show="show.memcontainer" ng-cloak>
				<form class="form">	
					<center ng-show="selectedType == 'tied'"><h2>{{term}}</h2></center>
					<input id="term" type="text" class="form-control"  ng-model="term" ng-change="updateArray()" ng-show="selectedType == 'untied'"><br>
					<div id="answera" placeholder="answer" ng-model="answer"></div><br>
					<div id="mem"  placeholder="mem" ng-model="mem"></div>
				</form><br>				
			</div>
			
			<div class="helpContainer" ng-show="show.helpcontainer" ng-cloak>
				<center><h3>Helper</h3></center>
				<input type="submit" class="form-control savebutton-{{saveButton}}" value="{{savingText}}" ng-click="sendData()">
				<input type="submit" class="form-control btn-primary" value="Go to Settings" ng-click="openSettings()">	
				<br>
				
			</div>
			<div class="untiedMemContainer" ng-show="show.untiedmemcontainer" ng-cloak>
				<center><h3>Other mems</h3></center>
				<br>	
				<form>
					<input type="text" class="form-control pull-left" style="width:170px" placeholder="New mem.." ng-model="newuntied">
					<input type="submit" class="btn btn-primary pull-right" ng-click="createUntiedMem()" value="create">
				</form><br>			
				<div ng-repeat="mem in untiedMems">
					<div class="untiedmem">
						<div class="row">
							<div class="co l-lg-10">
								<a href="#" ng-click="selectUntied({{mem.id}})">{{mem.term}}</a>
							</div>
							<div class="col-lg-2">
								<button type="button" class="pull-right btn btn-danger btn-xs" style="height:25px; top: 0px;" ng-click="delUntiedMem({{mem.id}})">
									<div class="close">&times;</div>
								</button>
							</div>
						</div>
					</div>
				</div>
				{{debug}}
			</div>
		</div>
		<div ng-show="show.settings" ng-cloak>
			<?php $this->renderPartial('common/settings'); ?>
		</div>
	</div>
	<script>
	$(function() {

		$('#dp').datepicker();
		$('.helpContainer').draggable(
			{ containment: "dragcontainer" }
		);
		// $('.untiedMemContainer').draggable(
		// 	{ containment: "dragcontainer" }
		// );
		$(".redactor_answer").delay(4000).attr("alt", 'test');
		var mindmaps = mindmaps || {};
		mindmaps.DEBUG = true;

		e = document.getElementById("mmCtrl");
		scope = angular.element(e).scope();

	});
	</script>
	<?php $this->renderPartial('common/wysiwyg'); ?>
</div>

<?php $this->renderPartial('mindmap/includes'); ?>