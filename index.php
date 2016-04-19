<?php
require_once ("assets/includes/global.php");
require_once ("assets/database/MysqliDb.php");
require_once ("assets/database/dbconnect.php");



//get current userid
$userid = 1;

//get current username
$db->where ("userId", $userid);
$user = $db->getOne ("tblusers");
$username = $user['username'];

//get categries
//$params = Array($userid);
$q = "(
SELECT c.categoryName,c.categoryId
FROM tblcategory c
)";
$categories = $db->rawQuery ($q);



//html page header and menu
require_once ("assets/includes/header.php");
?>


    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">
        <h1>Current User: <?php echo $username ?></h1>
      </div>

      <p class="lead"></p>
      <p>Categories</p>
      <hr>

      <div class="container">

        <div class="row">
        <?php
          $str = '';
          foreach ($categories as $category) {
              $str.= '<div class="col-md-4 categorybox">';
              $str.= $category['categoryName'] . '-'.$category['categoryId'].'<br/>';

              //get subcategories
              $params = Array($category['categoryId']);
              $q = "(
              SELECT sc.subcategoryName  FROM tblcatsubcatxref csx
              INNER JOIN tblsubcategory sc on csx.subcategoryId = sc.subcategoryId
              WHERE csx.categoryId = ?
              )";
              $subCategorys = $db->rawQuery ($q, $params);
              foreach ($subCategorys as $subCategory) {
                $str.= $subCategory['subcategoryName'] . ',';
              }

              $str.= '</div>';
          }
          $str = rtrim($str, ',');
          echo $str;

        ?>
        </div>
      </div>

    </div>


    <?php
    //html page footer
    require_once ("assets/includes/footer.php");
    ?>
