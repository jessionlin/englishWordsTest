<?php
 header("Content-Type:application/json;charset=utf-8");

if((isset($_POST['english']))&&(isset($_POST['chinese']))){
	check();
}
if((isset($_POST['english2']))&&(isset($_POST['chinese2']))){
	add();
}
if(isset($_POST['summary'])){
	summary();
}
if((!isset($_POST['english']))&&(isset($_POST['chinese']))){
	nextquestion();
}
//判定使用者的答案是否正确
function check(){
	$chinesewords = $_POST['chinese'];
	$englishwords = $_POST['english'];
	$result='{"success":false,"msg":"回答错误"}';
	$sql="select english from wordslist where chinese = '{$chinesewords}'";
	$list=query($sql);	
		if($list==$englishwords){
			$result='{"success":true,"msg":"回答正确"}';
		}
	echo $result;
}
//检查添加的是否是词库中的单词
function ifexit(){
	$chinesewords = $_POST['chinese2'];
	$englishwords = $_POST['english2'];
	$sql="select english from wordslist where chinese = '{$chinesewords}' and english='{$englishwords}'";
	$list=query($sql);
	return $list;
}
//跳转到下一题
function nextquestion(){
	$chinesewords = $_POST['chinese'];
	$sql="select id from wordslist where chinese = '{$chinesewords}'";
	$id=query($sql);
	if($id==1){
		$sql1 = "select chinese from wordslist where id = (select max(id) from wordslist)";
	}
	else if($id>1){
		$id--;
		$sql1 = "select chinese from wordslist where id ='{$id}'";
	} 
	$row=query($sql1);
	iconv('GBK', 'UTF-8', $row);
	$row = '"'.$row.'"';
	if($row){
			$result='{"success":true,"msg":"更新成功","question":'.$row.'}';
		}
		else{
			$result='{"success":false,"msg":"更新失败"}';
		}
	echo $result;
}

//添加错题本
function add(){
	if((isset($_POST['chinese2']))&&(isset($_POST['english2']))){
		$chinesewords = $_POST['chinese2'];
		$englishwords = $_POST['english2'];
		$date=date("Y.m.d");
		$list=ifexit();
		if(!$list){
			return $result='{"success":false,"msg":"储存失败，中英文不对应"}';
		}
		$sql="update wordslist set ifwrong = '1' , wrongdate = '{$date}' where chinese = '{$chinesewords}' and english='{$englishwords}'";
		$row=otherSQL($sql);
		if($row){
			$result='{"success":true,"msg":"储存成功"}';
		}
		else{
			$result='{"success":false,"msg":"储存失败"}';
		}
	}
	else{
		$result='{"success":false,"msg":"信息未接收到"}';
	}
	echo $result;
}
//添加心得
function summary(){
	if(isset($_POST['summary'])){
		$summary=$_POST['summary'];
		$date=date("Y.m.d");
		$sql="insert into summary(sum,sumdate) values('{$summary}','{$date}')";
		$row=otherSQL($sql);
		if($row){
			$result='{"success":true,"msg":"储存成功"}';
		}
		else{
			$result='{"success":false,"msg":"储存失败"}';
		}
	}
	else{
		$result='{"success":false,"msg":"信息未接收到"}';
	}
	echo $result;
}

//除查询外的其他操作
function otherSQL($sql){
	$link=mysqli_connect('localhost','root','root','englishtest');
	$result=mysqli_query($link,$sql);
	return $result;
}
//查询操作
function query($sql){
	$link=mysqli_connect('localhost','root','root','englishtest');
	mysqli_query($link,'set names utf8');
	$result = mysqli_query($link, $sql);
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if(isset($row['english']))
		return $row['english'];
		else if(isset($row['chinese']))
		return $row['chinese'];
		else if(isset($row['id']))
		return $row['id'];
	}
}
