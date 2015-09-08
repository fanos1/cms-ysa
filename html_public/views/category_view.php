<?php

?>



<div class="container">
    
    <div class="row">        
        <div class="col-md-12">
            
            <?php
            if ($rows) {              
                foreach ($rows as $array) {                    
                    echo '<h3><a href="article.php?id='.$array['id'].'">'. $array['title'] .'</a></h3>';
                    echo '<p class="articlepage-noimg">'.$array['content'] .'</p>';                                                                                              
                }              
            } 
           ?>            
        </div>
        
    </div>
        
</div>


