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
//判定使用者的答案是否正确
function check(){
	$chinesewords = $_POST['chinese'];
	$englishwords = $_POST['english'];
	$result='{"success":false,"msg":"回答错误"}';
	$list=findWord();
		if($list==$englishwords){
			$result='{"success":true,"msg":"回答正确"}';
		}
	echo $result;
}
//从文件中找出相应的单词
function findWord(){
	$chinesewords = $_POST['chinese'];
	$words=strDataString(read('wordslist.txt'),';',',');
	for($i=1;$i<count($words);$i++){
		if($words[$i][0]==$chinesewords){
			return $words[$i][1];
		}
	}
}
//跳转到下一题
function nextquestion(){
	$row=getNextWord();
	$row = '"'.$row.'"';
	if($row){
			$result='{"success":true,"msg":"更新成功","question":'.$row.'}';
		}
		else{
			$result='{"success":false,"msg":"更新失败"}';
		}
	echo $result;
}
//从文件中找出下一个词
function getNextWord(){
	$chinesewords = $_POST['chinese'];
	$words=strDataString(read('wordslist.txt'),';',',');
	for($i=1;$i<count($words);$i++){
		if($words[$i][0]==$chinesewords){
			if($i<count($words)-1){
				return $words[$i+1][0];
			}
			else return $words[1][0];
		}
	}
}
//添加错题本
function add(){
	if((isset($_POST['chinese2']))&&(isset($_POST['english2']))){
		$str=addWrong();
		if($str){
			$str  = getWrong();
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
//从文件中添加或删除错题本输入为1添加。0为删除
function addWrong(){
	$chinesewords = $_POST['chinese2'];
	$englishwords = $_POST['english2'];
	$date=date("Y.m.d");
	$if_exists = false;
	$words=strDataString(read('wordslist.txt'),';',',');
	for($i=1;$i<count($words);$i++){
		if(($words[$i][0]==$chinesewords)&&($words[$i][1]==$englishwords)){
			$if_exists = true;
			$words[$i][2]=1;
			$words[$i][3]=$date;
		}
	}
	if($if_exists){
		$str = mkTStr(turn($words));
			$file='wordslist.txt';
			write($str,$file,'w');
			return 1;
	}
	else{
		$str = $chinesewords.','.$englishwords.','.'1'.','.$date.';';
			$file='wordslist.txt';
			write($str,$file,'a');
			return 1;
	}
	
}
//将数组的存储顺序倒置
function turn($data){
	if(is_array($data)){
		$i=count($data)-1;
		$j=0;
		$arr = array();
		for($i;$i>-1;$i--){
			$arr[$j] = $data[$i];
			$j++;
		}
		return $arr;
	}
}
//获取错题本最新五项
function getWrong(){
	$str = NULL;
	$words=strDataString(read('wordslist.txt'),';',',');
	$i=0;
	$j = 1;
	for($i;$i<count($words);$i++){
		error_reporting(1);
		if((intval($words[$i][2]))&&($j<=5)){
			$str = $str .$j.','.mkOStr($words[$i]).';';
			$j++;
		}
	}
	$str = '"'.$str.'"';
	return $str;
}
//删除错词本中的某个单词
function deleteWrongWord($chinese){
	$ifSuc=deleteWords($chinese);
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

//删除单词
function deleteWords($chinese){
	$if_exists = false;
	$words=strDataString(read('wordslist.txt'),';',',');
	for($i=1;$i<count($words);$i++){
		if(($words[$i][0]==$chinese)){
			$if_exists = true;
			$words[$i][2]=0;
			$words[$i][3]=' ';
		}
	}
	if($if_exists){
		$str = mkTStr(turn($words));
			$file='wordslist.txt';
			write($str,$file,'w');
			return 1;
	}
	else{
		return 0;
	}
}
//获取心得列表前五项
function getSummary(){
	$str = NULL;
	//error_reporting(0);
	$words=strDataString(read('summary.txt'),';',',');
	$i=1;
	$str=NULL;
	$j=1;
	for($i;$i<count($words);$i++){
		if($j<=5){
			$str = $str .$j.','.mkOStr($words[$i]).';';		
			$j++;
		}
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
		$words=strDataString(read('wordslist.txt'),';',',');
		$strr = $summary.','.$date.';';
		$file='summary.txt';
		write($strr,$file,'a');
		$str = getSummary();
		if($strr){
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
//从文件中读取数据
function read($file){
	$str = file_get_contents($file);
	return $str;
}
//在文件末尾添加一段数据
function write($str,$file,$op='a'){
	$myfile = fopen($file,$op);
	 fwrite($myfile,$str);
}
/*拆解数据字符串 
*  输入字符串，两个操作符，第一个
*	操作符默认为';'，第二个默认为空
*	输出的数组第一个数据从下标为1开始
*/
function strDataString($str,$op1=';',$op2=NULL){
	$data = explode($op1,$str);
	if($op2){
		$i=0;
		$datas=array();
		for($i=count($data)-1;$i>-1;$i--){
			$datas[count($data)-1-$i]=explode($op2,$data[$i]);
		}
	}
	return $datas;
}
//将一维数组拼成字符串
function mkOStr($data,$op=','){
	if(is_array($data)){
		$j=1;
		$str = $data[0];
		for($j;$j<count($data);$j++){
			$str = $str . $op . $data[$j];
		}
		return $str;
	}
}
//将二维数组拼成字符串
function mkTStr($datas,$op=';'){
	if(is_array($datas)){
		$i=0;
		$str = NULL;
		for($i;$i<count($datas[$i]);$i++){
			$str = $str . mkOStr($datas[$i]) . $op;
		}
		return $str;
	}
}