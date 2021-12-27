<?php
include("connection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
$sql = "SELECT * FROM `MEMBER` WHERE MEMBER_ACCOUNT = ? && MEMBER_PASSWORD = ?;";
$statement = getPDO()->prepare($sql);
$statement->bindValue(1, $_POST['account']);
$statement->bindValue(2, $_POST['password']);
$statement->execute();
$data = $statement->fetchAll();
if (COUNT($data) > 0) {
    echo json_encode($data);
} else {
    echo "登入失敗";
}
