<?php Yii::app()->params['bodyBackgroundClass'] = ''; ?>
<div ng-app style="height:100%;">
	<?php $showMindMapHeader = true; ?>
	<?php Yii::import('ext.redactor.ImperaviRedactorWidget'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery-ui'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets_web/lib/angular/angular.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets_web/js/mindmapApp.js'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/assets_web/mindmap/css/app.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/assets_web/mindmap/css/minicolors/jquery.miniColors.css'); ?>

	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/css/datepicker.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/js/bootstrap-datepicker.js"); ?>
	<script src="<?php echo Yii::app()->request->baseUrl."/assets_web/lib/jqueryui/jquery-ui-1.10.3.js"; ?>"></script>
	<div class="row" ng-controller="MindMapCtrl" id="mmCtrl">

		<div ng-show="show.loading" >
			<div style="height:200px"></div>
			<center><h1>Loading...</h1></center>
		</div>

		<div ng-show="show.mindmap" ng-cloak>
			<div class="col-lg-9">
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
					<div id="canvas-container" style="height:500px;">
						<div id="drawing-area" class="no-select"></div>
					</div>
				</div>			
			</div>

			<div class="col-lg-3 mindmapBar">
				<div class="inner">
					<br><br><br><br>
					
					<div ng-show="show.memcontainer" class="memContainer" ng-cloak>
						<form class="form">	
							<center><h2>Current Item</h2></center>
							<div style="padding-left:13px">{{term}}</div><br>
							<div id="answera" placeholder="answer" ng-model="answer"></div><br>
							<div id="mem"  placeholder="mem" ng-model="mem"></div>
						</form><br>				
					</div>
					{{debug}}
					<div style="padding-top:450px">
						<input type="submit" class="btn btn-lg btn-primary pull-right" value="Settings" ng-click="openSettings()">	
						<input type="submit" class="btn btn-lg savebutton-{{saveButton}} pull-left" value="{{savingText}}" ng-click="sendData()">

					</div>
					
				</div>
				<div class="clear" style="height:800px"></div>
			</div>

		</div>
		<div ng-show="show.settings" ng-cloak>
			<?php $this->renderPartial('common/settings'); ?>
		</div>
	</div>
	<script>
	$(function() {

		$('#dp').datepicker();

		var mindmaps = mindmaps || {};
		mindmaps.DEBUG = true;	
		e = document.getElementById("mmCtrl");
		scope = angular.element(e).scope();
	});

	</script>
	<?php $this->renderPartial('common/wysiwyg'); ?>
</div>

<?php $this->renderPartial('mindmap/includes'); ?>

