<?php


?>

<div class="container">
    
    <?php     
    include ROOT.'/includes/formlogin.php'; 
    ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php
            if(isset($htmlOut)) {
                echo $htmlOut;
            }
            ?>
        </div>
    </div>    
</div>

