<?php
require('../includes/config.inc.php');
redirect_invalid_user('user_admin');
require(MYSQLi);

$errors = array();
$htmlOutput = '';
$errors = array();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit_button'])) {
	
        if( $_POST['token'] !==   $_SESSION['token'] )  {
            $errors[] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';            
        } 

        
        //http://stackoverflow.com/questions/3622433/how-effective-is-the-honeypot-technique-against-spam: hidden fiedl
        $honeypot = trim(strip_tags($_POST['med']) );   
        if (!empty($honeypot)) { 
            $errors[] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';     
        }
        
       
        $swearW = array('anal', 'arse', 'arselicker', 'ass', 'ass master', 'ass-kisser', 'asshole','balls','bastard','bitch','booby','bugger','bullocks','callboy','callgirl','clit',
            'cock','cockboy','cockfucker','cunt','cunt sucker','dickhead','dick','fuck','fuck face','fuck head','fucker','homo','homosexual','jerk','pervert','prick','shit','son of a bitch');

        if (!empty($_POST['title'])) {                         
            $cleanTitle = strip_tags($_POST['title']);                        
            $cleanTitle = str_ireplace( $swearW, '**', $cleanTitle);                        
        } else {
            $errors['title'] = '<div class="alert alert-danger">Please enter title!</div>';
        }

        if (!empty($_POST['category']) && filter_var($_POST['category'][0], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {            
            $catID = $_POST['category'][0];  
        } else {
            $errors['category'] = '<div class="alert alert-danger">Please select category from drop down. Category cannot be empty</div>';
        }
        
        
        if (!empty($_POST['content'])) {
            $allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote>';            
            $cleanCont = strip_tags($_POST['content'], $allowed);                        
            $cleanCont = str_ireplace( $swearW, '**', $cleanCont);                                    
        } else { 
            $errors['content'] = '<div class="alert alert-danger">Please enter the content!</div>';            
        }

      
        if (!empty($_POST['menu_display_name']) && preg_match("/^[a-z\s0-9]+$/i", $_POST['menu_display_name'])) {//only a-z and space allowed
            
            $cleanMenuName = strip_tags($_POST['menu_display_name']);   
        } else {
            $errors['menu_display_name'] = '<div class="alert alert-danger">For the menu display name, only a-z and space allowed! Make sure this is not emtpy</div>';            
        }
        

      
        if (empty($errors)) {            
            
            $user_id = 1;
            $img = NULL;           
            $imgErrors = array();
      
            if(empty($_FILES['imgfile']['tmp_name']) ) {                    
                $img = NULL;                                                            
                
            } else { 
                
                include './includes/validate_img.php';
                                
            }
            
            
            if(empty($imgErrors) ) {
              
                $stmt = mysqli_prepare($dbc, "INSERT INTO articles (title, content, user_id, img, menu_display_name) VALUES (?, ?, ?, ?, ?)");            

                if ($stmt ) {                
                                                 
                    if( mysqli_stmt_bind_param($stmt, 'ssiss', $cleanTitle, $cleanCont, $user_id, $img, $cleanMenuName) ) { 

                        if( !mysqli_stmt_execute($stmt) ) { trigger_error('Problem withe database');} 

                        $rowEfeected = mysqli_stmt_affected_rows($stmt);

                        if ($rowEfeected == 1) {                           
                            
                                                     
                            $articleID = mysqli_stmt_insert_id($stmt);
                            $articleID = (INT) $articleID;
                            $catID = (int)$catID;
                            $q = "INSERT INTO articles_categories(article_id, category_id) VALUES($articleID, $catID)";
                            $r = mysqli_query($dbc, $q);
                            if (mysqli_affected_rows($dbc) === 1) { 	
                            
                                $htmlOutput .= '<div class="alert alert-success"><h3>A new articles has been created!</h3></div>';                                 
                                $_POST = array();                                                                
                                $htmlOutput .= '<p><a href="./update-articles.php">Back to update all article pages</a></p>';   
                                
                                $displayForm = FALSE;                                
                               
                                
                            } else { 
                                echo '<div class="alert alert-danger"><h3>The page has been added!</h3></div>';
                                trigger_error('The page could not be added due to a system error. We apologize for any inconvenience.');
                                exit("<h3Sorry an error occured in create-article.php</h3>");
                            } 

                        } else if($rowEfeected == 0) {                                                
                            $htmlOutput .= '<div class="alert alert-danger"><h3>No data was updated in the database! please make sure you input the changes and than click submit</h3></div>';                          
                        } else { 
                            trigger_error('system error occured. Our sincere apologize!');               
                            exit();
                        }

                    } else {                    
                        trigger_error('The Bind failed, str140');               
                        exit("<h3>BIND FAILED</h3>");                    
                    }

                }
            }
            
        } else {                    
            if(isset($upload_errors) ) {
                foreach ($upload_errors as $k => $v) {
                  
                    echo '<div class="alert alert-danger"><h3>'.$v.'</h3></div>';
                }    
            }
        }  
        
    }
}

$_SESSION['token'] = md5(uniqid(rand(), true));
$token = htmlspecialchars($_SESSION['token']);
    
    
if(isset($error_page_title) && !empty($error_page_title)) {  
    $page_title = 'An error occured';
} else {
    $page_title = 'A list of article you can update';    
}
?>


<?php include('./includes/header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $htmlOutput; ?>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form enctype="multipart/form-data" action="" method="post" role="form" accept-charset="utf-8"> 
                <input type="hidden" name="token" id="formtoken" value="<?php echo isset($token) ? $token : ''; ?>" />
                <p class="hp" style="display: none;"> <input type="text" name="med" id="med" value=""> </p>

                <fieldset>
                    <legend>Fill in the form and click update </legend>
                    <?php
                    require('../includes/functions.php'); //                    
                    create_form_input('title', 'text', 'Title', $errors); 

                    $x = array_key_exists('category', $errors) ? ' has-error' : '';
                            
                   
                    echo '
                        <div class="form-group'. $x. '">
                        <label for="category" class="control-label">Under which category would you like this article displayed?</label>
                            <select name="category[]" class="form-control" multiple size="10">';

                               
                                $q = $q = 'SELECT * FROM categories';
                                $r = mysqli_query($dbc, $q);
                                if (mysqli_num_rows($r) > 0) { 
                                    while( list($id, $category, $menudisplayname) = mysqli_fetch_array($r) ) {

                                        $y = (isset($_POST['category'][0]) && ($_POST['category'][0] == $category) ) ? ' selected="selected"' : '';                                
                                        echo "<option value=\"$id\"$y> $category </option>";                                
                                    }
                                }                    
                            echo '</select>';

                        if (array_key_exists('category', $errors))  echo '<span class="help-block">' . $errors['category'] . '</span>';                        
                    echo '</div>';

                    //content field
                    create_form_input('content', 'textarea', 'The content of the article', $errors); 

                    create_form_input('menu_display_name', 'text', 'What should the menu display name be for this article?', $errors); 
                    
                    //image field
                    echo '
                    <div class="form-group">        
                        <label for="imagename">upload an image if you like, width 210 and height170</label>                         
                        <input type="file" name="imgfile" id="userfile" />
                    </div>';
                    ?>                    
                     
                    
                    <input type="submit" name="submit_button" value="Create Article" id="submit_button" class="btn btn-default" />	
                </fieldset>
            </form> 

            
        </div>
    </div>
</div>

 
<?php include('./includes/footer.php');  ?>