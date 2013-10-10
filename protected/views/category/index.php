<?php if(isset($_GET['id'])) $getId = $_GET['id'];else $getId = '0';?>
<div class="blurbg"></div>

<div class="container">
	<br>
	<center>
		<a href="<?php echo Yii::app()->createUrl('create/'. $getId); ?>" 
			class="btn btn-primary btn-lg">New learning set</a>
		  <!-- Button trigger modal -->
	<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">New folder</a>

	<?php $this->renderPartial('newmodal'); ?>

	<br><br>
    <?php foreach($folders as $m){ ?>		
		<div class="overviewContainer">
			<?php echo CHtml::link($m->name, array('category/index', 'id' => $m->id)); ?><br>
			<?php echo $m->info; ?>
			<?php
				echo CHtml::link(
				    'Delete',
				    array('category/delete', 'id' => $m->id),
					array('confirm' => 'Are you sure?', 'class' => 'btn btn-warning')
				);
			?>
		</div>
	<?php } ?>
	 <?php foreach($documents as $m){ ?>	
	 	<div class="overviewContainer">	
			<center><h3><?php echo $m->getDocName(); ?></h3> <?php echo $m->practiceCount(); ?></center>
			<div class="btn-group btn-group-justified">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/mindmap/<?php echo $m->id; ?> " 
					class="btn btn-primary">Edit</a>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/practice/<?php echo $m->id; ?> "
					class="btn btn-primary">Study</a>
				<?php
					echo CHtml::link(
					    'Delete',
					    array('API/deleteMindMap?id='.$m->id),
					    array('confirm' => 'Are you sure?', 'class' => 'btn btn-warning')
					);
				?>
			</div> 
		</div>
	<?php } ?>
</div>
