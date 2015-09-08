<?php



class Validator {

    protected $errors = array();
    protected $POSTED = array();
    protected $validSubmits = array(); 

    public function __construct() {
             
    }
    
    public function validateRegist($POST, $SESSION) {
		
                    
        if (!isset($POST['token']) || $POST['token'] !== $SESSION['token']) {
            $this->errors['token'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';
        }
   
        $honeypot = trim(strip_tags($_POST['med']));
        if (!empty($honeypot)) { 
            $this->errors['pot'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';
        }


        if (preg_match('/^[A-Z \'.-]{2,45}$/i', $POST['first_name'])) {            
            $this->validSubmits['fn'] = $POST['first_name'];
        } else {
            $this->errors['first_name'] = 'Please enter your first name!';
        }

        if (preg_match('/^[A-Z \'.-]{2,45}$/i', $POST['last_name'])) {            
            $this->validSubmits['ln'] = $POST['last_name'];
        } else {
            $this->errors['last_name'] = 'Please enter your last name!';
        }

		if (preg_match('/^[A-Z0-9]{2,45}$/i', $POST['username']) ) {
				$this->validSubmits['username'] = $POST['username'];
		} else {            
				$this->errors['username'] = 'Please enter a desired name using only letters and numbers!';
		}

        if (filter_var($POST['email'], FILTER_VALIDATE_EMAIL) === $POST['email']) {            
            $this->validSubmits['e'] = $POST['email'];
        } else {
            $this->errors['email'] = 'Please enter your last name!';
        }


        // Check for a password and match against the confirmed password:
        if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $POST['pass1'])) {
            if ($POST['pass1'] === $POST['pass2']) {                
                $this->validSubmits['p'] = $POST['pass1'];
            } else {
                $this->errors['pass2'] = 'Your password did not match the confirmed password!';
            }
        } else {
            
            $this->errors['pass1'] = 'Please enter a valid password!';
        }
        
        
    }
    
    
    public function validateLogin($POST, $SESSION) {             
        if (!isset($POST['token']) || $POST['token'] !== $SESSION['token']) {
            $this->errors['token'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';
        }

          
        $honeypot = trim(strip_tags($_POST['med']));
        if (!empty($honeypot)) {  
            $this->errors['pot'] = '<div class="alert alert-danger">The form submited is not valid. Please try again or contact support for additional assistance.</div>';
        }

        if (filter_var($POST['email'], FILTER_VALIDATE_EMAIL) === $POST['email']) {            
            $this->validSubmits['e'] = $POST['email'];
        } else {
            $this->errors['email'] = 'Please enter your last name!';
        }

        // Validate the password: This password will be compared against the password stored in DB in the Login.class        
        if (!empty($_POST['pass'])) {
            $p = $_POST['pass'];
            $this->validSubmits['p'] = $_POST['pass'];
        } else {            
            $this->errors['pass'] = 'Please enter your password!';
        }
      
        
    }



  
    public function getErrors() {
        return $this->errors;
    }

    public function getValidSubmits() {
        return $this->validSubmits;
    }
}

?>
