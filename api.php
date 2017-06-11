<?php 
if($_SERVER['SERVER_NAME']=='data.dev'){
    mysql_connect('localhost', 'root', '') or die("Can't connect to server");
    mysql_select_db('data_leo69_com_3f') or die("Can't connect database");
}else{
    mysql_connect('localhost', 'root', 'buiducliem1102') or die("Can't connect to server");
            mysql_select_db('center') or die("Can't connect database");   
}
mysql_query("SET NAMES 'utf8'") or die(mysql_error());
$possible_url = array("get_list_cate", "get_list_post");

$dataArr = array();

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
  if($_GET['action'] == 'get_list_post'){
    $str_cate_id = $_GET['str_cate_id'];
    $quantity = $_GET['quantity'];
    $site_publish = $_GET['site_publish'];
    $sql = "SELECT * FROM post WHERE cate_id IN ($str_cate_id) AND status = 1 ORDER BY RAND() LIMIT 0,".$quantity;
    $rs = mysql_query($sql);
    while($row = mysql_fetch_assoc($rs)){
      $dataArr[] = $row;
      $id = $row['id'];
      $published_at = date('Y-m-d');
      mysql_query("UPDATE post SET site_publish = '$site_publish', status = 0, published_at='$published_at' WHERE id = $id");
    }    
  }
  if($_GET['action'] == 'get_list_cate'){    
    $sql = "SELECT * FROM cate WHERE site_id = 1";
    $rs = mysql_query($sql);
    while($row = mysql_fetch_assoc($rs)){
      $site = $row['site_id'] == 1 ? "xvideos" : "sex.com";
	$tmp = explode('/', $row['url']);
	$row['tag_name'] = end($tmp);
      $dataArr[$row['id']] = $row;
    }    
  }
}
//return JSON array
exit(json_encode($dataArr));
?>
