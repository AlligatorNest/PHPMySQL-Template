<?php
require_once ("assets/database/MysqliDb.php");
error_reporting(E_ALL);
$db = new Mysqlidb('localhost', 'root', '', 'documents');
if(!$db) die("Database error");

//determine what action we need to process
$action = $_POST["action"];

// record document download
if ($action == 'download') {

  $dcoumentId =  $_POST["documentId"];
  $userId =  $_POST["userId"];

  $data = Array ("documentId" => $dcoumentId,
                 "userID" => $userId
               );

  $id = $db->insert ('tbldocumentuseraccess', $data);


}
?>
