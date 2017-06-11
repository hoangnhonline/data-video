<?php 
require_once "../model/Backend.php";
$model = new Backend();
$arrResult=array();
$term = $model->processData($_GET['term']);
$sql = "SELECT tag_id, tag_name FROM tag WHERE tag_name LIKE '%".$term."%' LIMIT 10 ";
$rs = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($rs)){
	$arrResult[] = array('id' => $row['tag_id'], 'value' => $row['tag_name']);
}
echo json_encode($arrResult);
?>