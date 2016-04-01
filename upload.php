<?php
require_once ("assets/database/MysqliDb.php");
error_reporting(E_ALL);
$db = new Mysqlidb('localhost', 'root', '', 'documents');
if(!$db) die("Database error");

//get list of all users
$users = $db->get('tblusers');

$msg = '';

//upload the document
//if($_POST && isset($_POST['action'], $_POST['documentName'], $_POST['documentCategory'], $_POST['users']))
if($_POST && isset($_POST['action'], $_POST['documentName']) && (isset($_POST['documentCategory']) || isset($_POST['users'])))

{
  $action = $_POST["action"];

  if ($action == 'uploadDocument') {

    $documentName = $_POST["documentName"];

    //get categorys to assign document to - in array if multiple
    $categoryIdAry = array();
    $categoryId=$_POST['documentCategory'];

    if ($categoryId)
    {
        foreach ($categoryId as $value)
        {
            array_push($categoryIdAry,$value);
        };
    };

    //get userIds to assign document to - in array if multiple
    $userIdAry = array();
    $userId=$_POST['users'];

    if ($userId)
    {
        foreach ($userId as $value)
        {
            array_push($userIdAry,$value);
        };
    };

    //insert document and get id
    $data = Array ("documentName" => $documentName);
    $documentId = $db->insert ('tbldocument', $data);

    //insert documentid and categoryIds
    foreach ($categoryIdAry as $categoryId) {
      $data = Array (
                      "documentId" => $documentId,
                      "categoryId" => $categoryId
                    );
      $documentCatId = $db->insert ('tbldocumentcategoryxref', $data);
    };

    //insert into documentUserXref table if users selected
    foreach ($userIdAry as $userId) {
      $data = Array (
                      "documentId" => $documentId,
                      "userId" => $userId
                    );
      $documentUserId = $db->insert ('tbldocumentUserXref', $data);
    };


    $msg = 'Your document has been uploaded.';

  };
};


//get categries for userid
$q = "(SELECT category,categoryId FROM tblcategory)";
$categories = $db->rawQuery ($q);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Documatic</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/custom-css.css" rel="stylesheet">


  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="/assets/images/logo-ph1.png"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Provider View</a></li>
            <li><a href="report.php">Admin: Reporting</a></li>
            <li class="active"><a href="upload.php">Admin: Upload</a></li>
            <li><a href="resetdemo.php">Reset Demo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">
        <h1>Document Upload</h1>
      </div>

      <p class="lead">Select category for document</p>
      <p class="bg-success"><?php echo $msg ?></p>
      <div class="container">

        <form method="post">
          <div class="form-group">
            <input type="hidden" name="action" value="uploadDocument">
            <label for="documentName">Document Name</label>
            <input type="text" class="form-control" id="documentName" name="documentName" placeholder="Document name">
          </div>

          <div class="form-group">
            <label for="documentFile">Select File</label>
            <input type="file" id="documentFile" name="documentFile">
            <p class="help-block">Select file to upload from your local computer.</p>
          </div>

          <label for="documentFile">Select Categoies</label>
          <select id="documentCategory[]" name="documentCategory[]" multiple class="form-control">
            <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category['categoryId'] .'">' . $category['category'] . '</option>';
            }
             ?>
          </select>
          <p class="help-block">Hold down Ctrl to select multiple categories.</p>

          <label for="Users">Select Users</label>
          <select id="users[]" name="users[]" multiple class="form-control">
            <?php
            foreach ($users as $user) {
                echo '<option value="' . $user['userId'] .'">' . $user['username'] . '</option>';
            }
             ?>
          </select>
          <p class="help-block">Hold down Ctrl to select multiple Users.</p>

          <button type="submit" class="btn btn-default">Submit</button>
          <button type="reset" class="btn btn-default" value="Reset">Reset</button>
        </form>

      </div>



    </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Peoples Health</p>
      </div>
    </footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
