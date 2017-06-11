<?php 
session_start();
require_once "../model/Backend.php";
$model = new Backend;

$id = $_POST['id'];
$order_id = $_POST['order_id'];
$amount = $_POST['amount'];
$price = $_POST['price'];
$vat = $_POST['vat'];
$ship = str_replace(",", "", $_POST['ship']);
$ship = (int) $ship;

if($amount==0){
	mysql_query("DELETE FROM order_detail WHERE id = $id");
}else{
	$total_detail = $amount*$price;
	mysql_query("UPDATE order_detail SET amount = $amount, total = $total_detail WHERE id = $id");
	$array['total_detail'] = $total_detail;
}
$sql = "SELECT * FROM order_detail WHERE order_id  =  $order_id";
$rs = mysql_query($sql);
$totalAmount = $totalPrice = 0;
while($row = mysql_fetch_assoc($rs)){
	$totalAmount+=$row['amount'];
	$totalPrice+=$row['total'];
}
$totalPay = $totalPrice + $vat*$totalPrice/100 + $ship;
$time = time();
$user_id = $_SESSION['user_id'];
$sql2 = "UPDATE orders SET total = $totalPay, sub_total = $totalPrice,total_amount = $totalAmount,
updated_at = $time , updated_by = $user_id	
 WHERE order_id = $order_id";
mysql_query($sql2) or die(mysql_error());
$array['totalAmount'] = $totalAmount;  
$array['totalPrice'] = $totalPrice;  
$array['totalPay'] = $totalPay;  
echo json_encode($array);

?>