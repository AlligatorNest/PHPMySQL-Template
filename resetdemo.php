<?php
require_once ("assets/includes/global.php");
require_once ("assets/database/MysqliDb.php");
require_once ("assets/database/dbconnect.php");


//html page header and menu
require_once ("assets/includes/header.php");
?>


    <!-- Begin page content -->
    <div class="container">

      <div class="page-header">


      </div>

<?php

$prefix = 'tbl';

$db = new Mysqlidb(Array (
                'host' => $db_server,
                'username' => $db_user,
                'password' => $db_pass,
                'db' => $db_name,
                'prefix' => $prefix,
                'charset' => null));
if(!$db) die("Database error");
$db->setTrace(true);
$tables = Array (
    'users' => Array (
        'userId' => 'int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (userId)',
        'username' => 'char(10) NOT NULL ',
        'password' => 'text NOT NULL ',
        'isActive' => 'TINYINT NOT NULL ',
        'email' => 'varchar(100) NULL ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'

    ),
    'role' => Array (
        'roleId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (roleId)',
        'roleName' => 'varchar(50) NOT NULL ',
        'isAdmin' => 'TINYINT NOT NULL ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'category' => Array (
        'categoryId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (categoryId)',
        'categoryName' => 'varchar(50) NOT NULL ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'subcategory' => Array (
        'subcategoryId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (subcategoryId)',
        'subcategoryName' => 'varchar(50) NOT NULL ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'catSubcatXref' => Array (
        'catSubcatXrefId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (catSubcatXrefId)',
        'categoryId' => 'int(11) not null ',
        'subcategoryId' => 'int(11) not null ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'ad' => Array (
        'adId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (adId)',
        'userID' => 'int(11) not null',
        'adTitle' => 'varchar(50) NOT NULL ',
        'adDescription' => 'text NOT NULL ',
        'adImagePath' => 'varchar(255) NULL ',
        'isActive' => 'TINYINT NOT NULL ',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'adCatXref' => Array (
        'adCatXrefId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (adCatXrefId)',
        'adId' => 'int(10) NOT NULL',
        'catId' => 'int(10) NOT NULL',
        'subCatId' => 'int(10) NOT NULL',
        'accessDate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ),
    'adviews' => Array (
        'adViewId' => 'int(11) not null AUTO_INCREMENT, PRIMARY KEY (adViewId)',
        'adId' => 'int(10) NOT NULL',
        'viewDate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'adddate' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP'
    )
);
$data = Array (
    'users' => Array (
        Array ('username' => 'bryan',
               'password' => 'bryan',
               'isActive' => '1',
               'email' => 'test@test.com',
               'adddate' => $db->now()
        )
    ),
    'role' => Array (
        Array ('roleName' => 'admin',
               'isAdmin' => '1',
               'adddate' => $db->now()
        ),
        Array ('roleName' => 'public',
               'isAdmin' => '0',
               'adddate' => $db->now()
        )
    ),
    'category' => Array (
        Array ( 'categoryName' => 'For Sale or For Free',
                'adddate' => $db->now()
        ),
        Array ( 'categoryName' => 'Community',
                'adddate' => $db->now()
        ),
        Array ( 'categoryName' => 'Professional Services',
                'adddate' => $db->now()
        ),
        Array ( 'categoryName' => 'Real Estate and Housing',
                'adddate' => $db->now()
        ),
        Array ( 'categoryName' => "I'm looking for",
                'adddate' => $db->now()
        )
    ),
    'subcategory' => Array (
        Array ( 'subcategoryName' => 'Merchandise',
                'adddate' => $db->now()
        ),
        Array ( 'subcategoryName' => 'Housing',
                'adddate' => $db->now()
        ),
        Array ( 'subcategoryName' => 'Music',
                'adddate' => $db->now()
        ),
        Array ( 'subcategoryName' => 'Clubs',
                'adddate' => $db->now()
        ),
        Array ( 'subcategoryName' => 'Stuff',
                'adddate' => $db->now()
        )
      ),
      'ad' => Array (
          Array ( 'userID' => 1,
                  'adTitle' => 'Tent for Sale',
                  'adDescription' => 'Red tent. Zip door and windows',
                  'isActive' => '1',
                  'adddate' => $db->now()
          ),
          Array ( 'userID' => 1,
                  'adTitle' => 'House for Sale',
                  'adDescription' => 'Red House. Located over yonder.',
                  'isActive' => '1',
                  'adddate' => $db->now()
          ),
          Array ( 'userID' => 1,
                  'adTitle' => 'DJ',
                  'adDescription' => 'I will DJ your party.',
                  'isActive' => '1',
                  'adddate' => $db->now()
          ),
          Array ( 'userID' => 1,
                  'adTitle' => 'Meeting of the Knights Templar',
                  'adDescription' => 'Rule the world from the shadows. Meet once a week.',
                  'isActive' => '1',
                  'adddate' => $db->now()
          ) ,
          Array ( 'userID' => 1,
                  'adTitle' => 'Mardi Gras Beads',
                  'adDescription' => 'Looking for old beads. Will pick up.',
                  'isActive' => '1',
                  'adddate' => $db->now()
          )
        ),
        'adCatXref' => Array (
            Array ( 'adId' => 1,
                    'catId' => 1,
                    'subCatId' => 1,
                    'accessDate' => $db->now(),
                    'adddate' => $db->now()
            ),
            Array ( 'adId' => 2,
                    'catId' => 2,
                    'subCatId' => 2,
                    'accessDate' => $db->now(),
                    'adddate' => $db->now()
            ),
            Array ( 'adId' => 2,
                    'catId' => 3,
                    'subCatId' => 3,
                    'accessDate' => $db->now(),
                    'adddate' => $db->now()
            ),
            Array ( 'adId' => 2,
                    'catId' => 4,
                    'subCatId' => 4,
                    'accessDate' => $db->now(),
                    'adddate' => $db->now()
            ),
            Array ( 'adId' => 2,
                    'catId' => 5,
                    'subCatId' => 5,
                    'accessDate' => $db->now(),
                    'adddate' => $db->now()
            )
          ),
          'catSubcatXref' => Array (
              Array ( 'categoryId' => 1,
                      'subCategoryId' => 1,
                      'adddate' => $db->now()
              ),
              Array ( 'categoryId' => 2,
                      'subCategoryId' => 2,
                      'adddate' => $db->now()
              ),
              Array ( 'categoryId' => 3,
                      'subCategoryId' => 3,
                      'adddate' => $db->now()
              ),
              Array ( 'categoryId' => 4,
                      'subCategoryId' => 4,
                      'adddate' => $db->now()
              ),
              Array ( 'categoryId' => 5,
                      'subCategoryId' => 5,
                      'adddate' => $db->now()
              )
            )
);
function createTable ($name, $data) {
    global $db;
    $count = 0;
    //$q = "CREATE TABLE $name (id INT(9) UNSIGNED PRIMARY KEY NOT NULL";
    $db->rawQuery("DROP TABLE IF EXISTS $name");
    //$q = "CREATE TABLE $name (id INT(9) UNSIGNED PRIMARY KEY AUTO_INCREMENT";
    $q = "CREATE TABLE $name (";

    foreach ($data as $k => $v) {
        if ($count == 0) {
          $q .= " $k $v";
        } else {
          $q .= ", $k $v";
        };

        $count ++;

    }
    $q .= ");";
    echo $q . '<br>';
    $db->rawQuery($q);
}
// rawQuery test
foreach ($tables as $name => $fields) {
    $db->rawQuery("DROP TABLE ".$prefix.$name);
    createTable ($prefix.$name, $fields);
}
if (!$db->ping()) {
    echo "db is not up";
    exit;
}

// insert test with autoincrement

foreach ($data as $name => $datas) {
    foreach ($datas as $d) {
        $id = $db->insert($name, $d);
        if ($id)
            $d['id'] = $id;
        else {
            echo "failed to insert: ".$db->getLastQuery() ."\n". $db->getLastError();
            exit;
        }
    }
}



echo "<p class='lead'>All done: ";
echo "Memory usage: ".memory_get_peak_usage()."</p>";
 ?>


 <?php
 //html page footer
 require_once ("assets/includes/footer.php");
 ?>
