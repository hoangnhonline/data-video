<?php 
require_once "../model/Backend.php";
$model = new Backend;

$action = $_POST['action'];

if($action == "save"){

	$id = $_POST['id'];
	$type = $_POST['type'];
	$status = $_POST['status'];
	$day = (int) $_POST['day'];

	$arrID = explode(",", rtrim($id,","));
	$arrType = explode(",", rtrim($type,","));
	$arrStatus = explode(",", rtrim($status,","));
	$i = 0;
	if(!empty($arrID)){
		mysql_query("DELETE FROM menu WHERE day = $day");
	}
	foreach ($arrID as $key => $value) {
		$i++;
		$typei = $arrType[$key];
		$statusi = $arrStatus[$key];
		if($value > 0){
			$sql = "INSERT INTO menu VALUES($value,$day,$typei,$i,$statusi)";
			mysql_query($sql) or die(mysql_error());	
		}
	}
}
if($action=="update"){
	mysql_query("DELETE FROM menu WHERE day = 1");
	mysql_query("UPDATE menu SET day = 1 , status = 1 WHERE day = 2");
}
if($action=="check_md5"){
	$password = $_POST['old_pass'];
	$md_pass = $_POST['old_pass_md5'];
	if(md5($password) != $md_pass){
		echo "0";
	}else{
		echo "1";
	}
}
if($action=="updateOrderCateType"){
	$str_id_order = $_POST['str_id_order'];
	$arrTmp = explode(";", $str_id_order);
	$i = 0;
	foreach ($arrTmp as $value) {
		if($value > 0){
			$i ++;
			$model->updateOrderCateType($value,$i);	
		}
	}
	
}	
if($action=="updateOrderCate"){
	$str_id_order = $_POST['str_id_order'];
	$arrTmp = explode(";", $str_id_order);
	$i = 0;
	foreach ($arrTmp as $value) {
		if($value > 0){
			$i ++;
			$model->updateOrderCate($value,$i);	
		}
	}
	
}	
if($action=="updateOrderCategory"){
	$str_id_order = $_POST['str_id_order'];
	$arrTmp = explode(";", $str_id_order);
	$i = 0;
	foreach ($arrTmp as $value) {
		if($value > 0){
			$i ++;
			$model->updateOrderCategory($value,$i);	
		}
	}	
}	
if($action=="updateOrderCateArticles"){
	$str_id_order = $_POST['str_id_order'];
	$arrTmp = explode(";", $str_id_order);
	$i = 0;
	foreach ($arrTmp as $value) {
		if($value > 0){
			$i ++;
			$model->updateOrderCateArticles($value,$i);	
		}
	}	
}	
?>