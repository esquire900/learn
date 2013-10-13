<div style="height:70px"></div>
<div class="container">
	<div class="row">
		<div style="height:20px"></div>
		<div class="col-lg-4 col-lg-offset-4">
			<div class="well">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Date of test</label>
						

						<div class="col-lg-8">
							<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							    $this->widget('CJuiDateTimePicker',array(

							        'name'=>'eventDate', //attribute name
							        'mode'=>'datetime', //use "time","date" or "datetime" (default)
							        'options'=>array(
							        	'timeFormat' => "hh:mm",
							        	'dateFormat' => 'dd-mm-yy'
							        ),  // jquery plugin options
							        'htmlOptions' => array(
							        	'ng-model' => 'setting.date',
							        	'class' => 'form-control'
							        )
							    ));
							?>
							
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Infinite learning?</label>
						<div class="col-lg-8">
							<input type="checkbox" ng-model="setting.infinite">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Algoritm</label>
						<div class="col-lg-8">
							<select class="form-control" ng-model="setting.algoritm">
							  <option>1</option>
							  <option>666</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Target Percentage</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" ng-model="setting.target">
						</div>
					</div>
					<input type="submit" value="go back" ng-click="hideSettings()" class="form-control btn btn-primary" style="width:100%">
					<br><br><br>
				</form>
			</div>
		</div>
	</div>
</div>