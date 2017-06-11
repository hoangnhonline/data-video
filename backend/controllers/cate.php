<?php 

$urlReturn = "../index.php?mod=cate&act=list";

require_once "../models/Backend.php";

$model = new Backend;

$id = (int) $_POST['cate_id'];

$arrInput['site_id'] = $site_id = (int) $_POST['site_id'];
$arrInput['name'] = $name = $_POST['name'];
$arrInput['url'] = $url = $_POST['url'];
$arrInput['quantity'] = $url = $_POST['quantity'];
$arrInput['status'] = $status = (int) $_POST['status'];

if($id > 0){
	$arrInput['id'] = $id;
	$model->update('cate', $arrInput);
}else{
	$model->insert('cate', $arrInput);
}
header('location:'.$urlReturn)

?>
