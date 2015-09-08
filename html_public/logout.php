<?php

require('./includes/config.inc.php');
require(MYSQL_PDO);


try {
    $dbc = dbConn::getConnection();
} catch (Exception $ex) {
    var_dump($this->getMessage().' line 15 INDEX.PHP ');
    exit("<h3>An Error Occured, We apologise</h3>");
}


// Destroy the session:
$_SESSION = array(); 
session_destroy(); 
setcookie (session_name(), '', time()-300); // Destroy the cookie.


$page_title = 'Logout';
include('./includes/header.php');


echo '
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>You have Logged Out successfully</h2>
        </div>
    </div>
</div>';

include('./includes/footer.php');
?>