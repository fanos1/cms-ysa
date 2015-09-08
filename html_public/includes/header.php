<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Driving lessons, driving school">    
        <meta name="description" content="<?php echo isset($page_title) ? $page_title . ',' : ''; ?>">
        
        <title><?php
            if (isset($page_title)) {
                echo $page_title;
            } else {
                echo 'YSA Driving School';
            }
            ?>
        </title>
        <!-- enables support for html5 tags in i.e < 9, load this only for ie < 9 -->
		<!--[if lt IE 9]>			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>			
		<![endif]-->		
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
        <link href="/css/bootstrap.min.css" rel="stylesheet">                        
        <link href="/css/custom.css" rel="stylesheet">    
        <!-- GLYPHICONS::  http://stackoverflow.com/questions/19608873/how-to-include-glyphicons-in-bootstrap-3   -->
    </head>




    <body>

    <hr/>
        
    <div class="container">
		<p class="skip-content"><a href="#main-content">skip to main content</a></p><br />
        <div class="row">
            <div class="col-lg-8">
                <p><img src="./img/logo.png" alt="ysadrivingschool logo" /></p>
            </div>
            <div class="col-lg-4">
                <img class="pull-right" src="./img/learn-to-drive-right.png" alt="learn to drive" />
            </div>
        </div>
    </div>

	
    <nav class="container">	
        <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
            <div class="container-fluid">
                
                <div class="navbar-header"><a class="navbar-brand" href="#">YSA</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>                
                </div>

                <div class="collapse navbar-collapse navbar-menubuilder">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <?php
                            $q = "SELECT 
                                c.menu_display_name,
                                c.id
                                FROM categories AS c
                                INNER JOIN menu_categories AS mc ON mc.category_id = c.id
                                WHERE mc.menu_id = 1"; 

                            $stmt = $dbc->query($q);                                                        
                            $r = $stmt->fetchAll(); 
                            
                            foreach ($r as $categories) {                                                                    

                                $q2 = 'SELECT id, title, menu_display_name '
                                        . 'FROM articles '
                                        . 'INNER JOIN articles_categories AS ac ON articles.id = ac.article_id '
                                        . 'WHERE ac.category_id ='.$categories['id'];
                                
                                $stmt2 = $dbc->query($q2);            
                                $r2 = $stmt2->fetchAll();                                                                  
                                
                                if(empty($r2)) {
                                    echo '
                                    <li>
                                        <a href="/category.php?id=' . $categories['id'] . '" title="' . $categories['menu_display_name'] . '">' 
                                            .htmlspecialchars($categories['menu_display_name']) . 
                                         '</a>
                                    </li>';

                                } else { 
                                    echo '
                                    <li class="dropdown">
                                        <a href="/category.php?id='.$categories['id'].'" class="dropdown-toggle" data-toggle="dropdown">'.
                                            $categories['menu_display_name'].'<b class="caret"></b>
                                        </a>                                         
                                        <ul class="dropdown-menu">';
                                            foreach($r2 as $articles) {
                                                echo '<li><a href="/article.php?id='.$articles['id'].'">'.                                                
                                                        $articles['menu_display_name'].'</a>'
                                                    . '</li>';
                                            }                                                                   
                                     echo '</ul>
                                    </li>';                                    
                                }
                                
                            }
                            ?>  
                        <li><a href="booking.php">Booking</a></li>
                        <?php
                        if(isset($_SESSION['user_admin']) || isset($_SESSION['user_id']) ) {
                            echo '<li><a href="logout.php">Log out</a></li>';
                        }
                        ?>
                    </ul>
                    
                </div>
            </div>
        </div>
    </nav>
    
    
    
    
    
    
  </html>   