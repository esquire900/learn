<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
  
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets_web/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	 

	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets_web/css/style.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

  <!-- Develop only! -->
 <!--  <?php if( $_SERVER['HTTP_HOST'] == "localhost"){ ?>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/Xreload.js"></script>
  <?php } ?> -->
  <!-- //devlop only -->
  <?php if(isset($showMindMapHeader)){
    echo file_get_contents('header.php');
  }
  ?>
	
</head>
<body class="<?php echo Yii::app()->params['bodyBackgroundClass']; ?>">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container"><!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a>
        </div>
        
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
           
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/overview">Learning Sets</a></li>
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/science">Science</a></li> 
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(Yii::app()->user->isGuest){ ?>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/login">Login</a></li> 
              <?php }else{ ?>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/profile"><?php echo Yii::app()->user->name; ?></a></li> 
               <?php } ?>


          </ul>
        </div><!-- /.navbar-collapse --></div>
    </nav>

<!--     <div class="clearme" style="height:70px"></div>
 -->
    <div style="height:54px"></div>

		<?php echo $content; ?>
<!-- 
		<div id="footer">
      <div class="container" style="padding-top:10px">
        <p class="text-muted credit">Credits to me© 2013.</p>
      </div>
    </div> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js"></script>
</body>
</html>
