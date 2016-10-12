<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>秒杀单词</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-default"><a href="#" class="navbar-brand">秒杀单词</a></nav>
	<div class="photos">
	<div class="carousel slide" id="myCarousel">
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>
	<div class="carousel-inner">
		<div class="item active">
			<img src="image/first.png" alt="0">
			<div class="carousel-caption middle"><font color="red" size="35">Do you want to study English well?</font></div>
		</div>
		<div class="item">
			<img src="image/second.png" alt="1">
			<div class="carousel-caption middle"><font color="red" size="35">OK,let's begin!</font></div>
		</div>
		<div class="item">
			<img src="image/third.png">
			<div class="carousel-caption" alt="2">
				<div class="btn btn-info begin" onclick="turn()">Go!!!</div>
			</div>
		</div>
	</div>
	<a href="#myCarousel" data-slide="prev" class="left carousel-control"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a href="#myCarousel" data-slide="next" class="right carousel-control"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
	</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
<script type="text/javascript">
	$('.carousel').carousel()
	function turn(){
		window.location="frontPage.html";
	}
</script>
</html>