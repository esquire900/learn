<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="parallax" style="background-image:url(
<?php echo Yii::app()->request->baseUrl; ?>/assets_web/images/brain.jpg
);">
	<center>
		<br><br><br>
		<h1 class="header-text">Unleash the power of le brain</h1>
	</center>
</div>
<?php Yii::app()->params['bodyBackgroundClass'] = ''; ?>
<div class="container">
	<br>
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-md-3" style="font-size:17px;">
				<h1><center class="index-icon" style="font-size:70px; margin-top:-20px; padding-bottom:7px">A+</center></h1>
				<b>Better results</b>, so less parents whining about your latest math-mark
			</div>
			<div class="col-lg-3 col-sm-6 col-md-3" style="font-size:17px;">
				<center><i class="icon-time index-icon"></i></center>
				<br>
				<b>Less time studying</b> = more time watching youtube cats
			</div>
			<div class="col-lg-3 col-sm-6 col-md-3" style="font-size:17px;">
				<center><i class="icon-smile index-icon"></i></center>
				<br>
				Look at that <b>smile</b>. Says it all.
			</div>
			<div class="col-lg-3 col-sm-6 col-md-3" style="font-size:17px;">
				<center><i class="icon-globe index-icon"></i></center>
				<br>
				Better <b>long-term retention</b>, meaning you still remember stuff when you actually need it
			</div>
		</div>
		<br>
		<div class="row">
			<div style="font-size:17px;" class="col-lg-6">
				<h3>
					Whats this sh*t?
				</h3>
				<iframe width="480" height="360" src="//www.youtube.com/embed/cEUnsMmXZ1g" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="col-lg-6">
				<center>
					<h3>
						So what are you waiting for? It's free! <br>
					</h3>
					<br>
					<span class="btn btn-primary btn-lg">Get started!</span>
					<span class="btn btn-link btn-lg"><a href="<?php echo Yii::app()->request->baseUrl; ?>/science"> or read the science</a></span>
				</center>
			</div>
			
		</div>
	</div>