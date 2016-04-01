<?php
require_once ("assets/database/MysqliDb.php");
error_reporting(E_ALL);
$db = new Mysqlidb('localhost', 'root', '', 'documents');
if(!$db) die("Database error");


//get current userid
$useridSelected = $_POST["userId"];

//get list of all users
$users = $db->get('tblusers');

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
            <li class="active"><a href="report.php">Admin: Reporting</a></li>
            <li><a href="upload.php">Admin: Upload</a></li>
            <li><a href="resetdemo.php">Reset Demo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">
        <h1>Document Access Reporting</h1>
      </div>

      <p class="lead">Document Download History</p>
      <div class="container">

        <form method="post" class="form-inline">

          <div class="form-group">
            <input type="hidden" name="action" value="auditUser">
            <label for="user">Select a user to audit:</label>

            <select name="userId" class="form-control">
              <?php
              $str = '';
              foreach ($users as $user) {

                  /*$str.= '<option value="' . $user['userId'] .'"';
                  //if ($useridSelected == $user['userId']){ $str.= 'selected="selected"'; }
                  $str.=  ($user['userId']  == $useridSelected  ? ' selected="selected"' : '');
                  $str.= '>';
                  $str.=  $user['username'] . '</option>';
                  */
                  echo '<option value="' . $user['userId'] .'"'
                  . ($user['userId']  == $useridSelected  ? ' selected="selected"' : '') . '>'
                  . $user['username'] . '</option>';
              }
              //echo $str;
               ?>
            </select>

          </div>

          <button type="submit" class="btn btn-default">Audit</button>

        </form>
      </div>

      <?php
      //determine what action we need to process
      $action = "";
      if (isset($_POST['action']))
      {
        $action = $_POST["action"];
      }

      /*********************
      *** if form was submitted,
      *** show results.
      ***********************/
      if ($action == 'auditUser') {

        $userid = $_POST["userId"];

        //get current username
        $db->where ("userId", $userid);
        $user = $db->getOne ("tblusers");
        $username = $user['username'];

        // get available documents for this userid assigned by Category
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

        // get available documents for this userid assigned by userid
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
          $msg =  $downloadCount . " new documents pending download for " . $username .".";
        } else {
          $msg = "No documents pending download.";
        };

        // get download history for this userid
        $params = Array($userid);
        $q = "(
        SELECT DISTINCT d.documentName,d.documentId,dua.accessDate
        FROM tblusers u
        INNER JOIN tbldocumentuseraccess dua on u.userId = dua.userId
        INNER JOIN tbldocument d on dua.documentId = d.documentId
        WHERE u.userId = ?
        ORDER BY dua.accessDate DESC

        )";
        $downloads = $db->rawQuery ($q, $params);
        ?>
        <p><hr></p>
        <div class="container">
          <div class="row">
            <div class="col-xs-12"><strong><?php echo $msg ?></strong></div>
          </div>
        <?php
        foreach ($documents as $document){
          echo '<div class="row">';
          echo '<div class="col-xs-4">' .$document['documentName'] . '</div><div class="col-xs-8">Pending</div>';
          echo '</div>';
        }

        foreach ($userdocuments as $userdocument){
          echo '<div class="row">';
          echo '<div class="col-xs-4">' .$userdocument['documentName'] . '</div><div class="col-xs-8">Pending</div>';
          echo '</div>';
        }

        foreach ($downloads as $download){
          echo '<div class="row">';
          echo '<div class="col-xs-4">' .$download['documentName'] . '</div><div class="col-xs-8">' .$download['accessDate'] . '</div>';
          echo '</div>';
        }

        ?>
        </div>

        <?php };?>
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
