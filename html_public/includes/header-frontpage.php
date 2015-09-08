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
                echo 'ysa driving school';
            }
            ?>
        </title>

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
        <link href="/css/bootstrap.min.css" rel="stylesheet">                        
        <link href="/css/custom.css" rel="stylesheet">                        
    </head>




    <body>
        
    <hr/>
    
    <div class="container">
		<p class="skip-content"><a href="#main-content">skip to main content</a></p><br />
 
        <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
            <div class="container-fluid">
                
                <div class="navbar-header"><a class="navbar-brand" href="#">Brand</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>                
                </div>

                <div class="collapse navbar-collapse navbar-menubuilder">
                    <ul class="nav navbar-nav">
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
                                if(!$r2) {echo "<h3>Error, header.php str80</h3>"; }
                                
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
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
  </html>  