<?php
require_once ("assets/database/MysqliDb.php");
error_reporting(E_ALL);
$db = new Mysqlidb('localhost', 'root', '', 'documents');
if(!$db) die("Database error");


//delete all records from documentuseraccess table
$db->rawQuery('DELETE FROM tbldocumentuseraccess');
$db->rawQuery('DELETE FROM tbldocumentuserxref');
$db->rawQuery('DELETE FROM tbldocumentcategoryxref WHERE adddate > "2016-03-27 15:49:36"');
$db->rawQuery('DELETE FROM tbldocument WHERE adddate > "2016-03-27 15:49:36"');

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
            <li><a href="upload.php">Admin: Upload</a></li>
            <li class="active"><a href="resetdemo.php">Reset Demo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">


      </div>

      <p class="lead">Demo Reset: Document download history deleted.</p>


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
