<div ng-app='practiceApp' class="practiceBackground">
	<div class="clear" style="height:70px"></div>
	<div class="row" ng-controller="PracticeCtrl" ng-keypress="handleKeypress">
		<div ng-class="alert.style" ng-show="show.alert" class="col-lg-6 col-lg-offset-3 col-sm-12 col-md-6 col-md-offset-3" style="margin-top:20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{alert.message}}
		</div>

		<div class="col-lg-6 col-lg-offset-3 questionContainer col-sm-12 col-md-6 col-md-offset-3">

			<div ng-show="show.question">
				<br>
				<div class="row">
					<div class="col-lg-2">
						<h1>
							<span class="glyphicon glyphicon-search"></span>
						</h1>
					</div>
					<div class="col-lg-10">
						<div class="question"><h1>{{question.text}}</h1></div>
						<div class="path">Path: [ <span ng-bind-html="question.path">></span> ]</div>
					</div>
				</div>	
				<br>
				<div class="mem row" ng-show="show.mem">
					<div class="col-lg-2">
						Hint
					</div>
					<div class="col-lg-10">
						<div ng-bind-html="mem.text" class="mem">
						</div>
					</div>
				</div>
				<br>	
				<div class="row">
					<div class="col-lg-2">
						<h1><span class="glyphicon glyphicon-pencil"></span></h1>
					</div>
					<div class="col-lg-10">
						<div class="answer" ng-show="show.answer">
							<br>
							<h3><center>
								<span ng-bind-html="answer.text"></span>
							</center></h3>
						</div>
						<div ng-show="show.thinkField">
							<h1>...</h1><br><br>
						</div>
						<div class="form" ng-show="show.writeField">
							<textarea type="text" ng-model="writeAnswer" class="form-control" placeholder="Typ answer"
								ng-focus="true == true">
							</textarea>
							<br>
							<div class="btn btn-primary btn-lg" ng-click="showWriteAnswer()">Send Answer</div>
							<div class="btn btn-dark" ng-click="showMem()">I need a hint</div>
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
					</div>
				</div>	
				<div class="row">
					<div class="col-lg-2">
						
					</div>
					<div class="col-lg-10">
						<div class="buttons" ng-show="show.buttonsQuestion">
							<div class="btn btn-primary btn-lg" ng-click="showAnswer()">Check</div>
							<div class="btn btn-dark" ng-click="showMem()">I need a hint</div>
						</div>

						<div class="buttons" ng-show="show.buttonsEval">
							<br><br><br>
							<div class="btn-group btn-group-justified">
								<div class="btn btn-success" ng-click="evaluate(1)">Correct</div>
								<div class="btn btn-default" ng-click="evaluate(2)">Partly right</div>
								<div class="btn btn-default" ng-click="evaluate(3)">Wrong</div>
							</div>
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