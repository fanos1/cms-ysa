
<div class="container" id="main-content">
    
    <div class="row">        
        <div class="col-md-3">          
            <?php
           
            if (isset($_SESSION['user_admin']) || isset($_SESSION['user_id']) ) {                 
                echo '<a href="booking.php">'
                    . '<img src="./img/200-pounds-10-lessons.jpg" alt="200 pounds driving lessons for 10 hours" />'
                . '</a>';                
            } else { 
                include ROOT.'/includes/formlogin.php';                                
            }
            
            ?>
        </div>            
        
        <div class="col-md-9">
            <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="./img/carousel1.jpg" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="./img/carousel2.jpg" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="./img/carousel3.jpg" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($rows) {              
                        foreach ($rows as $array) {
                            echo '<h3><a href="article.php?id='.$array['id'].'">'. $array['title'] .'</a></h3>';
                            echo $array['content'];
                            echo "<p>". $array['img'] ."</p>";
                        }              
                    } else {   echo 'no data returne'; }
                   ?>
                </div>           
            </div>

        </div>
    </div>    
    
</div>

