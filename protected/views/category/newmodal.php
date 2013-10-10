<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title">Create a new folder!</h4>
		</div>
	<div class="modal-body">
		<p>You can create a new folder here.</p>
		<form action="<?php echo Yii::app()->createUrl('category/create'); ?>" method="get">
			<input type="hidden" id="parent_id" name="parent_id" value="$getId">
			<input type="text" class="form-control" id="name" name="name" placeholder="Name">
			<br>
			<textarea name="info" id="info" cols="5" rows="2" class="form-control" placeholder="Extra info (not required)"></textarea>
			<br>
			<input type="submit" class="btn btn-primary" value="create">
		</form>
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  
	</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</center>