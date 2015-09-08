<?php

if (!defined('LIVE')) DEFINE('LIVE', TRUE);

$live = FALSE;
$thumb_width = 300;
$thumb_height = 230;  
        

DEFINE('CONTACT_EMAIL', 'example@yahoo.com');



define ('BASE_URI', '/home/ysadrivi' ); 
define ('BASE_URL', 'www.ysadrivingschool.com/');
define ('MYSQL_PDO', BASE_URI . '/pdo-connection.php');
define ('MYSQLi', BASE_URI . '/mysqli-connection.php');
define ('ROOT', $_SERVER['DOCUMENT_ROOT']); 
define ('IMAGE_DIR', ROOT.'/img/');
define ('VIEWS_PATH', ROOT.'/views/');

 

session_start();


//Code taken from Effortless E-commerce with PHP and MySQL (Voices That Matter) Paperback
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
    
    global $live;    
    $message = "An error occurred in script '$e_file' on line $e_line:\n$e_message\n";
    $message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";

    if (!$live) {           
        echo '<div class="alert alert-danger">' . nl2br($message) . '</div>';            
    } else { 
       
        error_log($message, 1); 
        if ($e_number != E_NOTICE) {
            echo '<div class="alert alert-danger">A system error occurred. We apologize for the inconvenience.</div>';
        }          
    }	
    return true; 
}  
set_error_handler('my_error_handler');


//PDO Uncaught Exception Handler
//PHP Master: Write Cutting Edge Code Paperback – 4 Nov 2011
function handleMissedException($e) {
	echo "Sorry, something is wrong. Please try again, or contact us.if the problem persists";
	error_log('Unhandled Exception Sam: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
}
set_exception_handler('handleMissedException');

function redirect_invalid_user($sessionId = 'user_id', $destination = 'index.php', $protocol = 'http://') {	
    
    if (!isset($_SESSION[$sessionId]) ) {
        $url = $protocol . BASE_URL . $destination; 
        header("Location: $url");   
        exit(); 
    }	
    //if SESSION[user_admin] is set, do nothing
} 



/* ============== 
 * SLASHES ARE STRIPPED IN /includes/function.php [create_form_input()] function
 * ==================
// http://stackoverflow.com/questions/4315406/php-magic-quotes-gpc-and-stripslashes-question 
// recursively strip slashes from an array. We will use our own addsales() before insertion to DB. 
// so, if SERVER has magiq quotes enabled, we will end up having 2 slashes. For this reason strip slashes if magic_quote() ON
// we use PDO prepared statement, so we won't have to add slashes before insertin in DB.
// PDO prevent SQL injection attacks by eliminating the need to manually quote the parameters
function stripslashes_r($array) {    
            
  foreach ($array as $key => $value) {
    $array[$key] = is_array($value) ? stripslashes_r($value) : stripslashes($value);
  }
  return $array;
}
 
if (get_magic_quotes_gpc()) {
  $_GET     = stripslashes_r($_GET);
  $_POST    = stripslashes_r($_POST);
  $_COOKIE  = stripslashes_r($_COOKIE);
}
 * 
 */
 ?>