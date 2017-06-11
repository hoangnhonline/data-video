<?php

require_once "../models/Backend.php";

$model = new Backend;

$mod = $_GET['mod'];

$id = $_GET['id'];

$model->delete($mod, $id);

header("location:../index.php?mod=".$mod."&act=list");

?>