<div class="row">
	<div class="col-lg-12 col-lg-offset-3">
	<br><br><br>
	<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
		$this->breadcrumbs=array(
			UserModule::t("Registration"),
		);
		?>
		
		<?php if(Yii::app()->user->hasFlash('registration')): ?>
		<div class="success">
		<?php echo Yii::app()->user->getFlash('registration'); ?>
		</div>
		<?php else: ?>
		
		<div class="form">
		<?php $form=$this->beginWidget('UActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation'=>true,
			'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
			'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'col-lg-6'),
		)); ?>
			<h1><center class="logo">Registration</center></h1>
			<?php echo $form->errorSummary(array($model,$profile)); ?>
			
			<?php echo $form->textField($model,'username', array('placeholder' => 'Username', 'class' => 'form-control')); ?>
			<?php echo $form->error($model,'username'); ?>

			<?php echo $form->passwordField($model,'password', array('placeholder' => 'Password', 'class' => 'form-control')); ?>
			<?php echo $form->error($model,'password'); ?>
		
			<?php echo $form->passwordField($model,'verifyPassword', array('placeholder' => 'Password (again)', 'class' => 'form-control')); ?>
			<?php echo $form->error($model,'verifyPassword'); ?>

			<?php echo $form->textField($model,'email', array('placeholder' => 'Email', 'class' => 'form-control')); ?>
			<?php echo $form->error($model,'email'); ?>
			
		<?php 
				$profileFields=$profile->getFields();
				if ($profileFields) {
					foreach($profileFields as $field) {
					?>

				<?php echo $form->labelEx($profile,$field->varname); ?>
				<?php 
				if ($field->widgetEdit($profile)) {
					echo $field->widgetEdit($profile);
				} elseif ($field->range) {
					echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
				} elseif ($field->field_type=="TEXT") {
					echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
				} else {
					echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
				}
				 ?>
				<?php echo $form->error($profile,$field->varname); ?>

					<?php
					}
				}
		?>

				<?php echo CHtml::submitButton(UserModule::t("Register"), array('class'=> 'btn btn-primary')); ?>

		<?php $this->endWidget(); ?>
		</div><!-- form -->
		<?php endif; ?>
	</div>
</div>