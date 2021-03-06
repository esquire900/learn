

<div class="row">
<?php echo CHtml::beginForm(); ?>

	<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

	<div class="success">
		<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
	</div>

	<?php endif; ?>	

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo CHtml::errorSummary($model); ?>

	<?php echo CHtml::activeLabelEx($model,'username'); ?>
	<?php echo CHtml::activeTextField($model,'username') ?>

	<?php echo CHtml::activeLabelEx($model,'password'); ?>
	<?php echo CHtml::activePasswordField($model,'password') ?>

	<p class="hint">
	<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
	</p>

	<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
	<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>

	<?php echo CHtml::submitButton(UserModule::t("Login")); ?>
<?php echo CHtml::endForm(); ?>


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),

    'htmlOptions' => array(
    	'class' => 'col-lg-4 col-lg-offset-3'
    ),
), $model);
?>