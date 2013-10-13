<?php 
$this->pageTitle=Yii::app()->name." - learning sets";

if(isset($_GET['id'])) $getId = $_GET['id'];else $getId = '0';?>
<div class="container">
	<div class="clear" style="height:70px"></div>
	<center>
		

		<?php $this->renderPartial('newmodal'); ?>
	</center>
	
	<?php
	if($getId != 0){
		echo '<ol class="breadcrumb">';
		$folder = Category::model()->findByPk($getId);
		foreach ($folder->breadcrumbs() as $name => $link) {
			echo '<li><a href="'.$link.'"';
			echo '>'.$name.'</a></li>';
		} 
		echo '</ol>';
	}else{
		echo "<div style='height:56px'></div>";
	}?>
	
	
	<div class="row">
		<div class="col-lg-3 overviewSideBar">
			<div class="infoBox">
				<h3>Hi <?php echo Yii::app()->user->name; ?> <i class="icon-smile pull-right Green"></i></h3>
				Good havng you today!
			</div>
			<br>
			<form action="" method="get">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
					<input type="text" class="form-control" placeholder="Search folders and sets" name="search">
				</div>
			</form>
			
		</div>
		<div class="col-lg-9">
			
		
			<div class="header">Learning sets 
				<div class="pull-right">
					<a href="<?php echo Yii::app()->createUrl('create/'. $getId); ?>" 
						class="btn btn-primary">New learning set</a>
					  <!-- Button trigger modal -->
					<a data-toggle="modal" href="#myModal" class="btn btn-dark">New folder</a>
				</div>
			</div>

			<div class="listContainer">

				
			    <?php foreach($folders as $m){ ?>		
					<div class="item">
						<a href="<?php echo Yii::app()->createUrl('overview/'.$m->id); ?>">
							<div class="row">
								<div class="col-lg-10">
									<?php echo $m->name ?><br>
									<small><?php echo $m->info; ?></small>
								</div>
								<div class=" col-lg-2 delBtn">
									<?php
										echo CHtml::link(
										    'Delete',
										    array('category/delete', 'id' => $m->id),
											array('confirm' => 'Are you sure?', 'class' => 'btn btn-warning')
										);
									?>
								</div>
							</div>
						</a>
					</div>
				<?php } ?>
				<?php foreach($documents as $m){ ?>	
				 	<div class="item">	
				 		<a href="<?php echo Yii::app()->request->baseUrl; ?>/mindmap/<?php echo $m->id; ?>">
				 		<div class="row">
				 			<div class="col-lg-7">
				 				<?php echo $m->getName(); ?><br>
				 				<small><?php echo $m->practiceCount(); ?></small> 
				 			</div>
				 			<div class="col-lg-5 pull-right btns">
				 				<a href="<?php echo Yii::app()->request->baseUrl; ?>/practice/<?php echo $m->id; ?> "
				 					class="btn btn-lg btn-primary"
				 					<?php if($m->practiceCount() == "Nothing yet."){
				 						echo 'disabled="disabled"';
				 					}?> >Study</a>
				 				<a href="<?php echo Yii::app()->request->baseUrl; ?>/mindmap/<?php echo $m->id; ?> " 
				 					class="btn btn-dark">Edit</a>
				 				
				 				<?php
				 					echo CHtml::link(
				 					    'Delete',
				 					    array('API/deleteDocument?id='.$m->id),
				 					    array('confirm' => 'Are you sure?', 'class' => 'btn btn-dark')
				 					);
				 				?>
				 			</div>
				 		</div>
				 		</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
