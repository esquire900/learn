<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="parallax">
	<div class="container">
	<div style="height:160px"></div>
		<div class="row">
			<div class="col-lg-8">
				<h1 class="pull-left" style="margin-bottom:0px;padding-bottom:0px">The only studytool</h1><br><br><br>
				<h3 class="pull-left">You'll evah need</h3>
			</div>
			<div class="col-lg-4">
				<div style="height:28px"></div>
				<a href="">
					<div class="fb-icon-bg"><center><i class="icon-facebook"></i></center></div>
					<center><div class="fb-bg"></div></center>
				</a>
				
				<a href="">
					<div class="twi-icon-bg"><center><i class="icon-twitter"></i></center></div>
					<center><div class="twi-bg"></div></center>
				</a>
				<a href="">
					<div class="g-icon-bg"><center><i class="icon-google-plus"></i></center></div>
					<center><div class="g-bg"></div></center>
				</a>
				<br>
				<p class="pull-left">Or use your <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration">email</a>. By logging in you agreed to have not read this sentence.</p>
			</div>
		</div>
	</div>
</div>
<nav class="navbar navbar-default" style="min-height:50px;">
  	<div class="container" style="width:800px"><!-- Brand and toggle get grouped for better mobile display -->
  		<div class="row">
			<ul class="nav nav-justified">
		    	<li><a href="#" onclick="scrollWhat();">WHAT IS THIS</a></li>
		    	<li><a href="#" onclick="scrollWhy();">WHY DOES IT WORK</a></li>
		  	</ul>
  		</div>
    </div>
</nav>
<script>
	function scrollWhat(){
		$('html,body').animate({
		scrollTop: $("#what").offset().top -60
		}, 800);
	}
	function scrollWhy(){
		$('html,body').animate({
		scrollTop: $("#why").offset().top -60
		}, 800);
	}
</script>

<div class="container">
	<div class="row" id="what">
		<div class="col-lg-6">
		<h1 class="index-icon" style="font-size:45px">What is this</h1>
			This is a project I started quite a while ago and grew to this website. It's an attempt to fit the best known study techniques and tricks into one neat package. It's optimized for 4 parameters: results, time efficieny, fun and long-term retention.
			<br><br>
			<div style="font-size:18px">In short, this helps you become a <span class="index-icon">better</span> student, while still having <span class="index-icon">fun</span> on the path to eternal <span class="index-icon">knowledge</span></div>
		</div>
	</div>
	<br><br>
	<div class="clear" style="height:40px"></div>
	<div class="row" id="why">
		<div class="col-lg-7">
			<div class="header">
				SCIENCE 
				<br><small>Click to go to the paper</small>

			</div>
			<div class="listContainer">	
				<a href="http://ctlt.ubc.ca/about-isotl/resources-archives/the-cognitive-science-of-learning-enhancement-optimizing-long-term-retention/">				    					
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							MetaStudy
						</div>
						<div class="col-lg-9">
							Metastudy (so a study which combines other studies) on the topic of learning. A lot of effects used in this projects are described here.	
						</div>
					</div>
				</div>
				</a>

				<a href="http://www.pashler.com/Articles/Pashler.Rohrer.Cepeda.Carpenter_2007.pdf">
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							ISI-IR effect
						</div>
						<div class="col-lg-9">
							Used in the main retention algoritms, basically it tells what the optimal times are between studying material, if material needs to be learned for a certain date (i.e. a test)
						</div>
					</div>
				</div>
				</a>

				<a href="http://www.pashler.com/Articles/Pashler.Rohrer.Cepeda.Carpenter_2007.pdf">
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							Real-world test
						</div>
						<div class="col-lg-9">
							This paper describes a project where students got the use a program which is kind of similar to this project. The results are quite amazing: while "good" students got ~ 20% better grades compared to self-study, "bad" students as much as quadrupled their grades (450% on average!)
						</div>
					</div>
				</div>
				</a>

				<a href="http://www.columbia.edu/cu/psychology/metcalfe/PDFs/Metcalfe%20Kornell%20Son%202007.pdf">
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							Real-world test
						</div>
						<div class="col-lg-9">
							This paper describes a project where students got the use a program which is kind of similar to this project. The results are quite amazing: while "good" students got ~ 20% better grades compared to self-study, "bad" students as much as quadrupled their grades (450% on average!)
						</div>
					</div>
				</div>
				</a>

				<a href="http://www.supermemo.com/english/ol/sm2.htm">
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							SuperMemo-2 Algoritm
						</div>
						<div class="col-lg-9">
							Main algoritm used for long-term retention. There are multiple reasons for using this outdated version (current is 11 if i'm correct). The most important ones are the complexity of higher versions, and the <a href="http://ankisrs.net/docs/manual.html#_what_spaced_repetition_algorithm_does_anki_use">criticism</a> received by anki. 
						</div>
					</div>
				</div>
				</a>

				<a href="http://anna.theworkexperiment.com/why-a-mind-map-is-such-a-powerful-tool/">
				<div class="item">
					<div class="row">
						<div class="col-lg-3">
							Mindmap webpage
						</div>
						<div class="col-lg-9">
							Not really a page with any links to papers, but more to prove a point (aka: still need to find the official research for this) 
						</div>
					</div>
				</div>
				</a>
			</div>
		</div>
		<div class="col-lg-5 pull-right">
		<h1 class="index-icon" style="font-size:45px;text-align:right;">Why does (or should) it work?</h1>
			<p class="pull-right" style="text-align:right;">It's a bit early to say it really works. There should be a scientific experiment for that, and my wallet isn't so keen for that. However, there is a lost of research done on this topic which suggests it works. And all I did is apply the research. So 1+1 = 2 right? :)</p>
		</div>
	</div>

</div>

<br><br><br>
<div class="footer">
	<div class="container">
	You can visit this project on <a href="http://github.com/esquire900/learn" target="_blank">github</a> or spam my ass at <a href="http://www.twitter.com/simonnouwens" target="_blank">twitter.</a> Happy learning!
	</div>
</div>