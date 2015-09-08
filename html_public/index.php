<?php
require('./includes/config.inc.php'); 
require(MYSQL_PDO); //this is to gets the signleton class which is holds the database connection    

try {
    $dbc = dbConn::getConnection();
} catch (Exception $ex) {
    
    exit("<h3>An Error Occured, We apologise</h3>");
}



include('./models/Articles.php');
$rows = Articles::getFrontPageArticles($dbc);



$page_title = 'ysa driving school';
include('./includes/header.php');
include ( VIEWS_PATH . "/index_view.php" );

?>


<?php include('./includes/footer.php'); ?>
