<?php
require_once ("assets/database/MysqliDb.php");
error_reporting(E_ALL);
$db = new Mysqlidb('localhost', 'root', '', 'documents');
if(!$db) die("Database error");


//get current userid
$userid = 1;

//get current username
$db->where ("userId", $userid);
$user = $db->getOne ("tblusers");
$username = $user['username'];

//get categries for userid
$params = Array($userid);
$q = "(
SELECT c.category
FROM tblusers u
INNER JOIN tblusercategoryxref ucX ON u.userId = ucx.userId
INNER JOIN tblcategory c ON ucx.categoryId = c.categoryId
WHERE u.userId = ?
)";
$categories = $db->rawQuery ($q, $params);

// get available documents for this userid BY CATEGORY
$params = Array($userid,$userid);
$q = "(
SELECT DISTINCT d.documentName,d.documentId
FROM tblusers u
INNER JOIN tblusercategoryxref ucX ON u.userId = ucx.userId
INNER JOIN tblcategory c ON ucx.categoryId = c.categoryId
INNER JOIN tbldocumentcategoryxref dcx on c.categoryId = dcx.categoryId
INNER JOIN tbldocument d on dcx.documentId = d.documentId
WHERE d.documentId not in (SELECT documentid from tbldocumentuseraccess where userID = ?) AND
u.userId = ?
)";
$documents = $db->rawQuery ($q, $params);
$downloadCount = $db->count;

// get available documents for this userid BY USERID
// these are documents assigned to particular user
$params = Array($userid,$userid);
$q = "(
SELECT DISTINCT d.documentName,d.documentId
FROM tblusers u
INNER JOIN tbldocumentuserxref dux on u.userId = dux.userId
INNER JOIN tbldocument d on dux.documentId = d.documentId
WHERE d.documentId not in (SELECT documentid from tbldocumentuseraccess where userID = ?) AND
u.userId = ?
)";
$userdocuments = $db->rawQuery ($q, $params);

$downloadCount += $db->count;

if ($downloadCount > 0) {
  $msg = "You have " . $downloadCount . " new documents available for download!";
} else {
  $msg = "You have no new documents available for download";
};


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
            <li class="active"><a href="index.php">Provider View</a></li>
            <li><a href="report.php">Admin: Reporting</a></li>
            <li><a href="upload.php">Admin: Upload</a></li>
            <li><a href="resetdemo.php">Reset Demo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">
        <h1>Current User: <?php echo $username ?></h1>

        <p><strong>Categories</strong>:
        <?php
        $str = '';
        foreach ($categories as $category) {
            $str.= $category['category'] .',';
        }
        $str = rtrim($str, ',');
        echo $str;
         ?>
       </p>

      </div>

      <p class="lead"><?php echo $msg?></p>
      <p>Documents Specific to these Categories:</p>
      <hr>
      <div class="container">
      <?php
      foreach ($documents as $document){
        echo '<div class="row">';
        echo '<div class="col-xs-4">' .$document['documentName'] . '</div><div class="col-xs-8">' . '<input id="' . $document['documentId'] . ',' . $userid . '" type="button" name="download" value="Download"> </div>';
        echo '</div>';
      }
      ?>
      </div>

      <hr>
      <p>Documents Specific to this User:</p>
      <hr>
      <div class="container">
      <?php
      foreach ($userdocuments as $userdocument){
        echo '<div class="row">';
        echo '<div class="col-xs-4">' .$userdocument['documentName'] . '</div><div class="col-xs-8">' . '<input id="' . $userdocument['documentId'] . ',' . $userid . '" type="button" name="download" value="Download"> </div>';
        echo '</div>';
      }
      ?>
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

    <!-- Script to capture document downloaded. -->
    <script>
    $(document).ready(function() {
        $('[name="download"]').click(function() {

            //get documentid and user id (documentId,userId)
            var $strId = this.id;
            //split on comma
            var $ary = $strId.split(',');

            var $documentId = $ary[0];
            var $userId = $ary[1];

            //ajax post to script to record download
            var request = $.ajax({
              url: "process.php",
              type: "POST",
              data: {action: "download", userId : $userId, documentId : $documentId},
              dataType: "html",
              success: function(data) {
                  //alert(data);
                  location.reload();
              }
            });


        });
    });
    </script>

  </body>
</html>
