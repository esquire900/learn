
<div ng-app>
	<?php $showMindMapHeader = true; ?>
	<?php Yii::import('ext.redactor.ImperaviRedactorWidget'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery-ui'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/angular.js/1.1.5/angular.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets_web/js/listApp.js'); ?>

	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/css/datepicker.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/assets_web/js/lib/datepicker/js/bootstrap-datepicker.js"); ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
	<div class="row" ng-controller="ListCtrl">

		<div ng-show="show.loading" >
			<div style="height:100px"></div>
			<center>loading</center>
		</div>

		<div class="itemContainer" ng-show="show.itemContainer" ng-cloak>

			<div class="memContainer">
				<form class="form">	
					<input id="term" type="text" class="form-control"  ng-model="term" 
						ng-change="updateArray()"><br>
					<div id="answera" placeholder="answer" ng-model="answer"></div><br>
					<div id="mem"  placeholder="mem" ng-model="mem"></div>
				</form><br>				
			</div>

			<center><h3>Items</h3></center>
			<br>	
			<form>
				<input type="text" class="form-control pull-left" style="width:170px" placeholder="New mem.." ng-model="newuntied">
				<input type="submit" class="btn btn-primary pull-right" ng-click="createUntiedMem()" value="create">
			</form><br>			
			<div ng-repeat="item in items">
				<div class="listItem">
					<div class="row">
						<div class="col-lg-10">
							<a href="#" ng-click="selectUntied({{mem.id}})">{{mem.term}}</a>
						</div>
						<div class="col-lg-2">
							<button type="button" class="pull-right btn btn-danger btn-xs" style="height:25px; top: 0px;" ng-click="delItem({{mem.id}})">
								<div class="close">&times;</div>
							</button>
						</div>
					</div>
				</div>
			</div>
			{{debug}}
		</div>
	</div>

	<script>
	$(function() {

		$('#dp').datepicker();
	});
	</script>
	<?php $this->renderPartial('common/wysiwyg'); ?>
</div>