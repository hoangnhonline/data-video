<?php 
require_once "../models/Backend.php";

$model = new Backend;
$site_id = $_GET['site_id'];
$arrCate = $model->getListCate($site_id);
$str = '<option value="-1">All</option>';
if(!empty($arrCate)){
	foreach ($arrCate as $key => $value) {
		$str.='<option value="'.$value['id'].'">'.$value['name'].'</option>';
	}
}
echo $str;
?>
