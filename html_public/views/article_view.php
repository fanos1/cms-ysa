<div class="container" id="main-content">

    <div class="row">        
        <div class="col-md-12">
            
            <?php
            //$rows returned from Model (defined in index.php Contoller page)
            if ($rows) {              
                foreach ($rows as $array) {                    
                    if(!empty($array['img'])) {
                        echo "<h1>". $array['title'] ."</h1>";
                        echo '<div class="articlepage">'.$array['content'].'</div>';
                        echo '<img src="./img/'. $array['img']. '" alt="'.$array['title'].'" width="300" height="230"/>';
                        echo '<div class="clearBoth"></div>'; 
                    } else {
                        echo "<h3>". $array['title'] ."</h3>";                                                                        
                        echo $array['content'];                                                                          
                    }
                    
                }              
            } 
           ?>            
        </div>
        
    </div>
        
</div>

