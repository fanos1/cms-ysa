<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($page_title)) { echo $page_title;} else { echo 'Learn to drive';} ?> </title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">      
    <link rel="stylesheet" href="./css/mystyles.css" media="screen">        	
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css"/>

    <script src="//code.jquery.com/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>        
    <script src="./js/hoverIntent.js"></script>
    <script src="./js/superfish.js"></script>

    <script>        
     
        jQuery(document).ready(function(){
            jQuery('ul.sf-menu').superfish();
        });

    </script>
    
</head>
	
	


<body>
<div class="container">
    <div class="header">
        <ul class="sf-menu" id="example">
            <li><a href="index.php">Home</a></li>                                  
            <li><a href="update-articles.php">update articles</a></li>           
            <li><a href="create-article.php">Create article</a></li>           
        </ul>
    </div>
</div>
    
