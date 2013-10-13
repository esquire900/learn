
<div class="container">
	<center>
		<br><br>
		<h1>What do you want to create?</h1>
		<br><br>
		<button class="btn btn-primary btn-lg" id="mm">Mindmap</button>
		<button class="btn btn-primary btn-lg" id="list" disabled="disabled">List</button>
	</center>
</div>
<script>

	$('#mm').click(function(){
		$.getJSON("<?php echo Yii::app()->createUrl('API/newMindMap', array('id' => $_GET['id'])); ?>", function(data){
			if(data.success == true){
				// go to mindmap page
				window.location = "<?php echo Yii::app()->createUrl('mindmap'); ?>"+"/"+data.data;
			}
		});		
	});
	$('#list').click(function(){
		$.getJSON("<?php echo Yii::app()->createUrl('API/newList', array('id' => $_GET['id'])); ?>", function(data){
			if(data.success == true){
				// go to mindmap page
				window.location = "<?php echo Yii::app()->createUrl('list'); ?>"+"/"+data.data;
			}
		});
	});
</script>