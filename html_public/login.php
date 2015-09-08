<?php

require('./includes/config.inc.php');
require(MYSQL_PDO);
include('./models/Login.php');

$showForm = TRUE; //Default is to always show registration form in the /view/. when user is successfuly registered, we don't show them the form, instead show success message
$htmlOut = '';

try {    
    
    $dbc = dbConn::getConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
              
        if(isset($_SESSION['user_admin']) ) {
            
            $htmlOut .= 'You are already logged-in';            
            
        } else {             
            include('./models/Validator.php');
            $validator = new Validator();
            $validator->validateLogin($_POST, $_SESSION);
            $login_errors = $validator->getErrors();
                        
            if (empty($login_errors)) {   
                
                $login = new Login();                
                $login->loginUser($dbc, $_POST['email'], $_POST['pass']); 

                if ($login->isLogedIn()) { 

                    $_SESSION['user_id'] = $login->getUserId();  
                    
                    if ($login->isUserAdmin()) {
                        $_SESSION['user_admin'] = true;//we use this session in /admin/ panel article to make sure that only the admin user can access to these article                                              
                    }                                      
                  
                    $url = '/admin/index.php'; 
                    header("Location: $url");
                    exit();
                    
                } else {                    
                    trigger_error('User log-in attempt failed, we apologise!');
                }

            } 
            

        }

    }

} catch (Exception $e) {
    echo "<h3> Main Catch Exception Login.php Control page: </h3>";
}


$page_title = 'Login page';
include('./includes/header.php');
include ( VIEWS_PATH . "/login_view.php" );


include('./includes/footer.php');
?>


