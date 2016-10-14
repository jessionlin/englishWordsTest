<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>秒杀单词</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/frontPage.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_coll">
				<span class="sr-only">响应布局</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand">首页</a>
		</div>
	</nav>
	<div class="row col-xs-9">
  		<div class="collapse navbar-collapse col-xs-3" id="nav_coll">
  			<ul class="nav nav-tabs nav-stacked size" data-spy="affix" style="font-size: 25px;font-family: '隶书';">
  				<li onclick="change(this)"><a href="#wordsTest">单次测评</a></li>
  				<li onclick="change(this)"><a href="#wordsWrong">错词本</a></li>
  				<li onclick="change(this)"><a href="#experience">学习心得</a></li>
  			</ul>
  		</div>
  			<div class="col-xs-6" style="float: right;">
  				<h2 id="wordsTest" class="item_name">单词测评</h2>
  				<table class="testArea">
  					<tr>
  						<td width="35%"><input id="chinese" value="长的" disabled/></td>
  						<td width="25%"><input type="text" placeholder="请输入答案" id="english" /></td>
  						<td width="25%"><div class="btn btn-info" id="sure">确定</div></td>
  						<td width="25%"><div class="btn btn-success" id="next">下一题</div></td>
  					</tr>
					<tr>
						<td><p id="ifRight"></p></td></td>
					</tr>
  				</table>
  				<h2 id="wordsWrong" class="item_name">错词本</h2>
  				<table class="table table-hover" style="text-align: center;" id="table_wronglist">
  					<thead>
  						<th width="10%" class="center">编号</th>
  						<th width="30%" class="center">中文</th>
  						<th width="25%" class="center">英文</th>
  						<th width="25%" class="center">时间</th>
						<th width="10%" class="center">操作</th>
  					</thead>
  				<tbody class="show_wrong_list">
  				</tbody>
  				</table>
  				<table class="testArea">
  					<tr>
  						<td width="30%"><input type="text" placeholder="中文" id="chinese_2" /></td>
  						<td width="5%">&nbsp;</td>
  						<td width="25%"><input type="text" placeholder="英文" id="english_2" /></td>
  						<td width="25%"><div class="btn btn-success" id="sure_2">确认</div></td>
  					</tr>
					<tr>
						<td><p id="display"></p></td>
					</tr>
  				</table>
  				<h2 id="experience" class="item_name">心得体会</h2>
				<table class="table table-hover" style="text-align: center;" id="table_summarylist">
  					<thead>
  						<th width="10%" class="center">编号</th>
  						<th width="30%" class="center">心得</th>
  						<th width="30%" class="center">时间</th>
						<th width="30%" class="center">操作</th>
  					</thead>
  				<tbody class="show_summary_list">
  				</tbody>
  				</table>
  				<table class="testArea">
					<tr>
						<td width="30%"><input type="text" placeholder="心得" id="summary"/></td>
  						<td width="25%"><div class="btn btn-success" id="sure_3">确认</div></td>
					</tr>
					<tr>
						<td><p id="display_2"></p></td>
					</tr>
				</table>
  			</div>
  	</div>
  	<script type="text/javascript" src="js/jquery.js"></script>
  	<script type="text/javascript" src="js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="js/navbar.js"></script>
</body>
</html>