<?php
include("connection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
//建立SQL語法
$sql = "UPDATE `PRODUCT` SET `PRODUCT_NAME` = ?, `PRODUCT_SUM` = ?, `PRODUCT_STATE` = ? WHERE (`ID` = ?);
";



//執行並查詢，會回傳查詢結果的物件，必須使用fetch、fetchAll...等方式取得資料

$statement = getPDO()->prepare($sql);
$statement->bindValue(1, $_POST['name']);
$statement->bindValue(2, $_POST['sum']);
$statement->bindValue(3, $_POST['state']);
$statement->bindValue(4, $_POST['id']);
$statement->execute();
echo "success";
