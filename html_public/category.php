<?php
require('./includes/config.inc.php');
require(MYSQL_PDO);

if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) 
{
    $cat_id = (int) $_GET['id']; 
    
    
    include('./models/Categories.php');
    $dbc = dbConn::getConnection();        
    $rows = Categories::getArticlesByCategory($dbc, $cat_id);
    
    
    $page_title = 'category page';
    include('./includes/header.php');    
    include ( VIEWS_PATH . "/category_view.php" );
    
} 
else { 
	$page_title = 'Error!';
	include('./includes/header2.php');
	echo '<div class="alert alert-danger">This page has been accessed in error2.</div>';
}
// Include the HTML footer:
include('./includes/footer.php');
?>