<?php

function resizeHoang($file,$width,$height,$file_name,$des){
	require_once "class.resize.php";
	$re = new resizes;
	$re->load($file);
	$re->resize($width,$height);
	$re->save($des.$file_name);
}
function changeTitle($str) {
    $str = stripUnicode($str);
    $str = str_replace("?", "", $str);
    $str = str_replace("&", "", $str);
    $str = str_replace("'", "", $str);
    $str = str_replace("  ", " ", $str);
    $str = trim($str);
    $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8'); // MB_CASE_UPPER/MB_CASE_TITLE/MB_CASE_LOWER
    $str = str_replace(" ", "-", $str);
    $str = str_replace("---", "-", $str);
    $str = str_replace("--", "-", $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('"', "", $str);
    $str = str_replace(":", "", $str);
    $str = str_replace("(", "", $str);
    $str = str_replace(")", "", $str);
    $str = str_replace(",", "", $str);
    $str = str_replace(".", "", $str);
    $str = str_replace("%", "", $str);
    return $str;
}
function stripUnicode($str) {
    if (!$str)
        return false;
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ',
        'D' => 'Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        '' => '?',
        '-' => '/'
    );
    foreach ($unicode as $khongdau => $codau) {
        $arr = explode("|", $codau);
        $str = str_replace($arr, $khongdau, $str);
    }
    return $str;
}

$allowedExts = array("jpg", "jpeg", "gif", "png");
$arrResult = array();
if(!is_dir("../../upload/post/".date('Y/m/d')."/".time().'/'))
mkdir("../../upload/post/".date('Y/m/d')."/".time().'/',0777,true);

$url = "../../upload/post/".date('Y/m/d')."/".time().'/';
$count =0;
for($i=0;$i<count($_FILES['myfile']['name']);$i++){
	$extension = end(explode(".", $_FILES["myfile"]["name"][$i]));
	if ((($_FILES["myfile"]["type"][$i] == "image/gif") || ($_FILES["myfile"]["type"][$i] == "image/jpeg") || ($_FILES["myfile"]["type"][$i] == "image/png")
	|| ($_FILES["myfile"]["type"][$i] == "image/jpeg"))	
	&& in_array($extension, $allowedExts))
	  {
	  if ($_FILES["myfile"]["error"][$i] > 0)
		{
		//echo "Return Code: " . $_FILES["myfile"]["error"][$i] . "<br />";
		}
	  else
		{		
	
		if (file_exists($url. $_FILES["myfile"]["name"][$i]))
		  {
		  //echo $_FILES["myfile"]["name"][$i] . " đã tồn tại. "."<br />";		 
		  }
		else
		  {

		  	$arrPartImage = explode('.', $_FILES["myfile"]["name"][$i]);

            // Get image extension
            $imgExt = array_pop($arrPartImage);

            // Get image not extension
            $img = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $arrPartImage));
            
            $img = changeTitle($img);
            $img = $img."_".time();
            $name = "{$img}.{$imgExt}";

 

            if(move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$url. $name)==true){            
				$count++;
				$hinh = str_replace("../","",$url). $name;
                $arrReturn[]['filename'] = $hinh;				
            }
		  }
		}
		
	  }
	  

}
$arrResult['fileList'] = $arrReturn;
if($count==0){
		$arrResult['fileList'] = array();
}
echo json_encode($arrResult);
?>