<div style="height:70px"></div>
<div class="blurbg"></div>
<div class="container">
	<div class="row">
		<div style="height:20px"></div>
		<div class="col-lg-4 col-lg-offset-4">
			<div class="well">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Date of test</label>
						<div class="col-lg-8">
							<div class="input-append date" id="dp" data-date="" data-date-format="dd-mm-yyyy">
								<input ng-model="setting.date" size="16" type="text" value="" placeholder="Date">
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							
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