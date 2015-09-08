<?php
require('../includes/config.inc.php');
redirect_invalid_user('user_admin');
require(MYSQLi);


$page_title = 'A list of articles you can update';
include('./includes/header.php');

$syntax_errors = array();

$r = mysqli_query($dbc, "SELECT id, title FROM articles ORDER BY title ASC");
if(!$r) exit("<h3>Sorry, system error occured, we apologize</h3>");

if(mysqli_num_rows($r) > 0) {
   
    echo '
<div class="container">
    <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Article Title</th>
              <th>Article Description</th>          
            </tr>
          </thead>
          <tbody>';

      
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                  
            echo '        
                <tr>
                    <td>'.htmlspecialchars($row['id']).'</td> 
                    <td><a href="update-an-article.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></td>                

                    <td><a href="update-an-article.php?id=' . $row['id'] . '">Update</a></td>
                </tr>            
            ';        
        }
       
        echo '</tbody></table>
    </div>
</div>';
}


include('./includes/footer.php');
?>
