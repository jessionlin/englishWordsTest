<?php
require_once 'config.php';
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
if((isset($_REQUEST['act']))&&(isset($_REQUEST['chinese']))){
	if($_REQUEST['act']=="delete"){
		deleteWrongWord($_REQUEST['chinese']);
	}
}
if((isset($_REQUEST['act']))&&(isset($_REQUEST['id']))){
	if($_REQUEST['act']=="delete"){
		deleteSummary($_REQUEST['id']);
	}
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
	iconv('GBK', 'UTF-8', $row);//转换中文字符串编码
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
		$str = getWrong();
		if($row){
			$result='{"success":true,"msg":"储存成功","content":'.$str.'}';
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
//获取错题本前五项
function getWrong(){
	$str = NULL;
	$sql="select id,chinese,english,wrongdate from wordslist where ifwrong=1 order by id desc limit 0,5";
	$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$result = mysqli_query($link, $sql);
	$i=0;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		iconv('GBK', 'UTF-8', $row['chinese']);
		$str = $str.$row['id'].','.$row['chinese'].','.$row['english'].','.$row['wrongdate'].';';
		$i++;
	}
	$str = '"'.$str.'"';
	return $str;
}
//删除错词本中的某个单词
function deleteWrongWord($chinese){
	$sql="update wordslist set ifwrong = 0 and wrongdate = NULL where chinese = '{$chinese}'";
	$ifSuc=otherSQL($sql);
	if($ifSuc){
		$url='frontPage.php';
		echo "<script>";
		echo "window.location.href='{$url}'";//页面跳转函数
		echo "</script>";
	}
	else{
		echo "<script>";
		echo "alert("."'"."跳转失败"."'".")";//页面跳转函数
		echo "</script>";
		echo $sql;
	}
}
//删除心得列表的某条记录
function deleteSummary($id){
	$sql="delete from summary where id = '{$id}'";
	$ifSuc=otherSQL($sql);
	if($ifSuc){
		$url='frontPage.php';
		echo "<script>";
		echo "window.location.href='{$url}'";//页面跳转函数
		echo "</script>";
	}
	else{
		echo "<script>";
		echo "alert("."'"."跳转失败"."'".")";//页面跳转函数
		echo "</script>";
		echo $sql;
	}
}
//获取心得列表前五项
function getSummary(){
	$str = NULL;
	$sql="select id,sum,sumdate from summary order by id desc limit 0,5";
	$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$result = mysqli_query($link, $sql);
	$i=0;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		//iconv('GBK', 'UTF-8', $row['sum']);
		$str = $str.$row['id'].','.$row['sum'].','.$row['sumdate'].';';
		$i++;
	}
	$str = '"'.$str.'"';
	return $str;
}
//添加心得
function summary(){
	if(isset($_POST['summary'])){
		$summary=$_POST['summary'];
		if(strstr($summary,',')){
			$summary=str_replace(',','。',$summary);
		}
		$date=date("Y.m.d");
		$sql="insert into summary(sum,sumdate) values('{$summary}','{$date}')";
		$row=otherSQL($sql);
		$str = getSummary();
		if($row){
			$result='{"success":true,"msg":"储存成功","content":'.$str.'}';
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
	$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$result=mysqli_query($link,$sql);
	return $result;
}
//查询操作
function query($sql){
	$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
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
