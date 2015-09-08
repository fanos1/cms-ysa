<?php

require('./includes/config.inc.php');
require(MYSQL_PDO);


if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) 
{
    $article_id = (int) $_GET['id']; 
    
    include('./models/Articles.php');
    $dbc = dbConn::getConnection();        
    $rows = Articles::getArticleById($dbc, $article_id);
    
  
    $page_title = 'Here are all articles';
    include('./includes/header.php');    
    include ( VIEWS_PATH . "/article_view.php" );

}  
else { 
    $page_title = 'Error!';
    include('./includes/header.php');
    echo '<div class="alert alert-danger">This page has been accessed in error2.</div>';
}

include('./includes/footer.php');  
?>