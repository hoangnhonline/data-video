<?php 
require_once "../model/Backend.php";
$model = new Backend;

$action = $_POST['action'];
                     
if($action=='ajax-checkbox'){
	$value = (int) $_POST['val'];
	$product_id = (int) $_POST['product_id'];
	$col = $_POST['type'];
	$model->updateTypeProduct($product_id,$col,$value);
}
if($action=='ten-kd'){	
	$name = $_POST['name'];
	echo $a = $model->stripUnicode($name);
	exit();
}
if($action == 'cate_menu'){
	$value = (int) $_POST['val'];
	$cate_id = (int) $_POST['cate_id'];	
	$model->updateHoteCate($cate_id,$value);
}
if($action == "get-cate-by-type-product"){
	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}else{
		$type="form";
	}
	$cate_type_id = (int) $_POST['cate_type_id'];
	$arrCate = $model->getListCate($cate_type_id);	
	if(!empty($arrCate)){
		if($type!="form"){ 
			echo "<option value='-1' selected >--Tất cả--</option>";
		}else{
			echo "<option value='0' selected >--Chọn--</option>";
		}
		foreach ($arrCate as $cate1) {
			echo "<option data-parent='".$cate1['id']."' value='".$cate1['id']."'>".$cate1['cate_name']."</option>";
			if(!empty($cate1['child'])){
				foreach ($cate1['child'] as $cate2) {
					echo "<option data-parent='".$cate2['parent_id']."' value='".$cate2['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cate2['cate_name']."</option>";					
				}			
			}
		}
	}

}
if($action == "get-cate-by-type"){
	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}else{
		$type="form";
	}
	$cate_type_id = (int) $_POST['cate_type_id'];
	$model->getCateByCateType($cate_type_id,$type);	

}
if($action == "get-manu-by-type"){
	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}else{
		$type="form";
	}
	$cate_type_id = (int) $_POST['cate_type_id'];
	$resultArr = $model->getManuByCateType($cate_type_id);
	echo ($type = "list") ? "<option value='-1' >--Tất cả--</option>" : "<option value='0'>--chọn--</option>";
	if(!empty($resultArr)){
		foreach ($resultArr as $cate) {
			?>
			<option value="<?php echo $cate['id']; ?>"><?php echo $cate['manu_name']; ?></option>
			<?php 
		}
	}

}
if($action == "check-product-code"){
	$product_code = $_POST['product_code'];
	$rs = $model->checkProductCode($product_code);	
}
?>