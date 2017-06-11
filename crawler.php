<?php 
set_time_limit(0);
require "simplehtmldom/simple_html_dom.php";
// lay tin 
//mysql_connect("localhost","root","");
//mysql_select_db("leech");
if($_SERVER['SERVER_NAME']=='data.dev'){
    mysql_connect('localhost', 'root', '') or die("Can't connect to server");
    mysql_select_db('center') or die("Can't connect database");
}else{
   mysql_connect('localhost', 'root', 'buiducliem1102') or die("Can't connect to server");
            mysql_select_db('center') or die("Can't connect database");  
}

mysql_query("SET NAMES 'utf8'");
$b = isset($_GET['b']) ? $_GET['b'] : 1;
$offset_cate = $b*7;
$rs = mysql_query("SELECT * FROM cate WHERE status = 1 AND site_id = 1 ORDER BY id DESC LIMIT $offset_cate,7");
$noCate = mysql_num_rows($rs);
if($noCate == 0) {
	echo "end_cate"; exit();
}
$arrDataXvideo = array();
$page = $_GET['p'] ? $_GET['p'] : 1;
while($row = mysql_fetch_assoc($rs)){
	$url = $row['url']."/".$page;
	$site_id = $row['site_id'];
	$cate_id = $row['id'];
	if($site_id == 1){
		$arrDataXvideo = xvideos($url);		
	}
	
	if(!empty($arrDataXvideo)){		
		$arrInput = array();
		$co = 0;
		foreach ($arrDataXvideo as $value) {			
			if(checkExistId(1, $value['id'])){
				$co++;
				$arrInput['videoId'] = $value['id'];
				$arrInput['site_id'] = 1;
				$arrInput['cate_id'] = $cate_id;
				$arrInput['title'] = str_replace("'", "", $value['title']);
				$arrInput['videoUrl'] = $value['videoUrl'];
				$arrInput['thumbnailUrl'] = $value['thumbnailUrl'];
				$arrInput['duration'] = $value['time'];
				$arrInput['status'] = 1;
				$arrInput['created_at'] = date('Y-m-d');				
				$id = insert('post', $arrInput);
				echo $co."--1507--".$value['title']."<hr />";
			}
		}
	}	
	//sleep(3);
}
function xvideos($url) {	
	$linkArr=array();
	$k = 0;	
	echo "<h4>".$url."</h4>";
	$html = file_get_html($url);
	$domain = "http://www.xvideos.com";
	foreach ($html->find(".thumbBlock") as $div){
			// get id video
			$tmp = explode("_",$div->attr['id']);
			$videoID = $tmp['1'];
			if($videoID > 0){
				if(isset($div->children[0]->children[2])){
					$textTime = $div->children[0]->children[2]->children[0]->children[0]->innerText();

				
						$k++;										
						
						$textTime= str_replace("(", "", $textTime);
						$textTime= str_replace(")", "", $textTime);
						$linkArr[$videoID]['id'] = $videoID;
						$linkArr[$videoID]['time'] = $textTime;				
						$linkArr[$videoID]['videoUrl'] = $domain.$div->children[0]->children[0]->children[0]->attr['href'];
						// get thumnail 
						$thumnailUrl = $div->children[0]->children[0]->children[0]->children[0]->attr['src'];
						$linkArr[$videoID]['thumbnailUrl'] = str_replace("thumbs", "thumbsll", $thumnailUrl);		
						// get title
						$linkArr[$videoID]['title'] = str_replace("...", "" ,$div->children[0]->children[1]->children[0]->innerText());				
					
				}
			}
					
	}
	
	$html->clear(); //lenh xoa cache Dom, neu khong co ham nay thi bo nho ram se day
	unset($html);
	return $linkArr;
}

function checkTimeXvideos($text){
	if(strpos($text, "h") > 0){
		return true;
	}else{
		$text = explode(" ", $text);	
		$text = trim($text[0]);	
		$text = str_replace(" ", "", $text);
		$text = str_replace("(", "", $text);		
		return (int) $text > 7 ? true : false;
	}
	
}
function sexCom($url) {	
	$linkArr=array();
		
	$html = file_get_html($url);
	$domain = "http://www.sex.com";
	foreach ($html->find(".small_pin_box") as $div){
		
		if(isset($div->children[1]->children[2])){
			$tmp = $div->children[1]->attr['href'];
			$tmp = explode("video/", $tmp);
			$tmp = explode("-", $tmp[1]);
			$videoID = $tmp[0];	
			if($videoID > 0){
				$textTime = $div->children[1]->children[2]->innerText();
				if(checkTimeSexCom($textTime)){										
					$urlDetail = $div->children[1]->attr['href'];
					$urlDetail = $domain.$urlDetail;
					$videoUrl = getIdVideoSexCom($urlDetail);				
							
					$thumnailUrl = $div->children[1]->children[0]->attr['data-src'];
					$title = $div->children[1]->children[1]->attr['alt'];

					if(strpos($videoUrl, '.mp4') > 0){
						$linkArr[$videoID]['id'] = $videoID;
						$linkArr[$videoID]['videoUrl'] = $videoUrl;
						$linkArr[$videoID]['thumbnailUrl'] = $thumnailUrl;
						$linkArr[$videoID]['time'] = $textTime;
						$linkArr[$videoID]['title'] = $title;
					}
				}
			}
		}
		
				
	}				
	
	$html->clear(); //lenh xoa cache Dom, neu khong co ham nay thi bo nho ram se day
	unset($html);
	return $linkArr;
}
function getVideoURLSexCom($videoID){	
	$url = "http://www.sex.com/video/embed?id=".$videoID;
	$html = file_get_html($url);
	$div = $html->find('script', 3)->innerText();
	//get url video
	$tmp = explode('file: "', $div);	
	$a = $tmp[1];
	$arrtmp = explode('",', $a);	
	return $videoUrl = $arrtmp[0];
}
function getIdVideoSexCom($urlDetail){
	$html = file_get_html($urlDetail);
	$div = $html->find('iframe',0)->attr['src'];	
	$tmp = explode("id=", $div);
	$tmp = explode("&pinId", $tmp[1]);	
	$videoID = (int) $tmp[0];	
	return $videoUrl = getVideoURLSexCom($videoID);
}
function checkTimeSexCom($textTime){	
	$textTime = explode(":", $textTime);
	$textTime = trim($textTime[0]);	

	if($textTime=="HD"){
		return true;
	}else{	
		return (int) $textTime > 7 ? true : false;
	}
}
function insert($table,$arrParams){
	$column = $values = "";

	foreach ($arrParams as $key => $value) {
	    $column .= "$key".",";
	    $values .= "'".$value."'".",";
	}
	$column = rtrim($column,",");
	$values = rtrim($values,",");
	$sql = "INSERT INTO ".$table."(".$column.") VALUES (".$values.")";
	mysql_query($sql);
	$id = mysql_insert_id();
	return $id;
}
function getListVideoIdSite($site_id){
	$dataArr = array();
	$sql = "SELECT videoId FROM post WHERE site_id = $site_id";
	$rs = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($rs)){
		$dataArr[] = $row['videoId']; 
	}
	return $dataArr;
}
function checkExistId($site_id, $videoId){
	$dataArr = array();
	$sql = "SELECT videoId FROM post WHERE site_id = $site_id AND videoId = '$videoId'";
	$rs = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($rs);	
	return $num > 0 ? false : true;	
}
?>

