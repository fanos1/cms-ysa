<?php

require('./includes/config.inc.php');
require(MYSQL_PDO);


try {
    
    $dbc = dbConn::getConnection();
    $valid_errors = array();
    $showForm = TRUE; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                        
        include('./models/Validator.php');
        $validator = new Validator();
        $validator->validateRegist($_POST, $_SESSION);
        $valid_errors = $validator->getErrors();
       
               
        if (empty($valid_errors)) {
            
            include('./models/Register.php');
                     
            
			//Code taken from: PHP Master: Write Cutting Edge Code Paperback – 4 Nov 2011
            try {
                $regObj = new Register();                                  
                $regObj->registerUser($dbc, $_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['pass1']);                 
                $regErr = $regObj->getErrrors();
                               
                if (empty($regErr)) {                    
                    $showForm = FALSE;                   
                }                                 
            } catch (SignUpEmailException $e) {
                var_dump($e->getMessage());
                echo "<h3>line 146, SignUpEmailException, signup.php </h3>";
            } catch (SignUpNotUniqueException $e) {
                var_dump($e->getMessage());
                echo "<h3>line 150, SignUpNotUNIQUEException, signup.php </h3>";
            } catch (SignUpDatabaseException $e) {
                var_dump($e->getMessage());
                echo "<h3>line 154, SignUpDatabaseException, signup.php </h3>";
            } catch (SignUpException $e) {
                var_dump($e->getMessage());
                echo "<h1>line 159, signup.php file, </h1>";
              
            }
        }
        
        
    } // End of the REQUEST_METHOD


    $_SESSION['token'] = md5(uniqid(rand(), true));
    $token = htmlspecialchars($_SESSION['token']);
    
} catch (Exception $e) {
    echo "<h3>90 register</h3>";
    
    var_dump($e->getMessage()); 
   
    $display = "<h2>sorry an arror occured, line 65. index.php </h2>";
}



$page_title = 'Login page';
include('./includes/header.php');
include ( VIEWS_PATH . "/register_view.php" );


include('./includes/footer.php');
?>