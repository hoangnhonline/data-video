<?php
//var_dump($_SERVER['DOCUMENT_ROOT']);
//ini_set('display_errors',1);
//echo time();
ob_start();
if(!isset($_SESSION))
{
    session_start();
}
if(isset($_SESSION['user_id'])== FALSE) {
    $_SESSION['back']= $_SERVER['REQUEST_URI'];
    $_SESSION['error']= "Bạn chưa đăng nhập";
    header("location: login.php");
}
include "defined.php";
$mod='';
if(isset($_GET['mod']))
{
    $mod = $_GET['mod'];
}
require_once "models/Backend.php";
$model = new Backend;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data Center</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">AUTO DATA</a>

        </div>     
        <a href="logout.php" style="float:right;margin:10px; margin-bottom:0px;color:#FFF" title="Logout">Logout</a>   
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li <?php if($mod == "" || $mod == "site" ){ ?> class="active" <?php } ?> >              <a href="index.php?mod=site&act=list">Site  </a></li>
            <li <?php if($mod == "cate" ){ ?> class="active" <?php } ?>><a href="index.php?mod=cate&act=list"
              
              >Cate</a></li>
            <li <?php if($mod == "video" ){ ?> class="active" <?php } ?>><a href="index.php?mod=video&act=list"
             
              >Video</a></li>          
          </ul>         
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
           $act = isset($_GET['act']) ? $_GET['act'] : "";

          if ($mod=="") include "views/site/list.php";
          else include "views/".$mod.'/'.$act.'.php';

          ?>
          
        </div>
      </div>
    </div>    
    <script src="js/lazyload.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
       //$("img.lazy").lazyload();
    });
    </script>
  </body>
</html>
