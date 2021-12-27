<?php
include("connection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
//建立SQL語法
$sql = "DELETE FROM `PRODUCT` WHERE (`ID` = ?)";



//執行並查詢，會回傳查詢結果的物件，必須使用fetch、fetchAll...等方式取得資料

$statement = getPDO()->prepare($sql);
$statement->bindValue(1, $_POST['id']);
$statement->execute();
echo "success";
