<div ng-app='practiceApp' class="grey-bg">
	<div class="row" ng-controller="PracticeCtrl" ng-keypress="handleKeypress">
		<div ng-class="alert.style" ng-show="show.alert" class="col-lg-6 col-lg-offset-3 col-sm-12 col-md-6 col-md-offset-3" style="margin-top:20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{alert.message}}
		</div>

		<div class="col-lg-6 col-lg-offset-3 questionContainer col-sm-12 col-md-6 col-md-offset-3">

			<div ng-show="show.question">
				<br>
				<div class="">
					<div class="question"><center><h1>{{question.text}}</h1></center></div>
					<div class="path"><center>Path: [ <span ng-bind-html="question.path">></span> ]</center></div>
					<div class="answer" ng-show="show.answer">
						<br>
						<h3><center>
							<span ng-bind-html="answer.text"></span>
						</center></h3>
					</div>
					<div class="mem" ng-show="show.mem" ng-bind-html="mem.text"></div>
				</div>
				<br>
				<div class="form" ng-show="show.writeField">
					<textarea type="text" ng-model="writeAnswer" class="form-control" placeholder="Typ answer"
						ng-focus="true == true">
					</textarea>
					<br>
					<center>
						<div class="btn btn-primary btn-lg" ng-click="showWriteAnswer()">Send Answer</div>
					</center>

				</div>
				<div ng-show="show.writeAnswer">
					<div class="row">
						<div class="col-lg-5 pull-left writeStatedAnswer">
							{{writeAnswer}}
						</div>
						<div class="col-lg-5 pull-right writeStatedAnswer">
							<span ng-bind-html="answer.text"></span>
						</div>
					</div>
				</div>
				<div class="buttons" ng-show="show.buttonsQuestion">
					<br><br>
					<center>
						<div class="btn btn-primary btn-lg" ng-click="showAnswer()">Show Answer</div>
						<div class="btn btn-default btn-lg" ng-click="showMem()">Show mem</div>
					</center>
				</div>

				<div class="buttons" ng-show="show.buttonsEval">
					<br><br><br>
					<div class="btn-group btn-group-justified">
						<div class="btn btn-primary" ng-click="evaluate(1)">Correct</div>
						<div class="btn btn-default" ng-click="evaluate(2)">Partly right</div>
						<div class="btn btn-default" ng-click="evaluate(3)">Wrong</div>
					</div>
				</div>
				
			</div>
			<br>
			<div ng-show="show.loading">
				<h1><center>Loading <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets_web/images/ajax-loader.gif" alt=""></center></h1>
			</div>
			
			<div ng-show="show.done">
				<h1>You + this session = done</h1>
			</div>
		</div>
	</div>
	<?php Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/angular.js/1.1.5/angular.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets_web/js/practiceapp.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile("http://code.angularjs.org/1.0.1/angular-sanitize-1.0.1.js "); ?>

</div>