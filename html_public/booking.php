
<?php 
require('./includes/config.inc.php'); 
require(MYSQL_PDO); //this is to gets the signleton class which is holds the database connection  
  
try {
    $dbc = dbConn::getConnection();
} catch (Exception $e) {
    
    exit("<h3>An Error Occured, We apologise</h3>");
}


$errors = array();
$htmlOut = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    if(!isset($_POST['tokne']) || $_POST['token'] !== $_SESSION['token'] ) {        
        $errors['token'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>'; 
    }          
    $honeypot = trim(strip_tags($_POST['med']) );   
    if (!empty($honeypot)) {
        $errors['pot'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';     
    }
    
    if (preg_match('/^[A-Z \'.-s]{2,45}$/i', $_POST['name'])) {
        $name = strip_tags($_POST['name']);
    } else {
        $errors['name'] = 'Please enter your name!';
    }
            
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) {
        $email = strip_tags($_POST['email']);        
    } else {
        $errors['email'] = 'Please enter a valid email address!';
    }
    
    if (preg_match('/^[0-9]{8,16}$/', $_POST['phone'])) {
        $phone = strip_tags($_POST['phone']);
    } else {
        $errors['phone'] = 'Please enter your phone';
    }
    	    
    if (preg_match('/^[0-9a-z\s]{1,46}$/i', $_POST['address1'])) {
        $address1 = strip_tags($_POST['address1']);
    } else {
        $errors['address1'] = 'First address you entered is not valid!';
    }
    
    
    if (preg_match('/^[0-9a-z\s]{1,8}$/i', $_POST['postcode'])) {
        $postcode = strip_tags($_POST['postcode']);
    } else {
        $errors['postcode'] = 'Please enter  postcode!';
    }
    
 
    
    if(preg_match("/^[a-z0-9\,.-_$&%*()+]$/i", $_POST['textmessage']) ) {
        $textAreaMsg = strip_tags($_POST['textmessage']);
    } else {
		//text area is optional to fill, if user left it empty No Error created
		$textAreaMsg = 'No Additional Info Requested';
	}
    
    
    // Send the email if no error    
    if(empty($errors)) {                
                
        $table = '
        <table class="table">
            <thead>
              <tr>                        
                <th>Booking Enquiry From Yildizlondra Website</th>                    
              </tr>
            </thead>
            <tbody>
                <tr>                                              
                  <td>name: <strong>'. $name.'</strong></td>
                </tr>
                <tr>                      
                  <td>email: <strong>'. $email.'</strong></td>                    
                </tr>
                <tr>                                            
                  <td>phone: <strong>'. $phone.'</strong></td>                    
                </tr>
                <tr>                                            
                  <td>address1: <strong>'. $address1.'</strong></td>                    
                </tr>
                <tr>                                            
                  <td>postcode: <strong>'. $postcode.'</strong></td>                      
                </tr>
                              
                <tr>                                            
                  <td>Any additional information: <strong>'. $textAreaMsg.'</strong></td>            
                </tr>

            </tbody>
        </table>                  
        ';
        
        $to = "sama@yahoo.com";
        
        $subject = "New booking enquiry from SYA Driving website";
        
        $message = "<b>This is a new HTML message coming from customer.</b>";
        $message .= "<div>$table</div>";
                 
        $header = "From:booking@sya.co.uk \r\n";
        $header .= "Cc:n.akbar@sya.com \r\n";		
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        $retval = mail($to, $subject, $message, $header);
        
        if($retval) {			           
           $htmlOut .= '<h3 class="alert alert-success">Message sent successfully...We will be in touch soon!</h3>';
        }
        else {
           $htmlOut .= '<h3 class="alert alert-error" Message could not be sent...</h3>';  
        }        
    } 
}


$_SESSION['token'] = md5(uniqid(rand(), true));
$token = htmlspecialchars($_SESSION['token']);
?>


<?php

$page_title = 'Booking page';
include('./includes/header.php');
include ( VIEWS_PATH . "/booking_view.php" );

?>

<?php include('./includes/footer.php'); ?>