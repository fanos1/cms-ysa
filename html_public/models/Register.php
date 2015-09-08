<?php

class SignUpException extends Exception {

    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
        error_log('Error in ' . $this->getFile() . ' Line: ' . $this->getLine() . ' Error: ' . $this->getMessage());
        var_dump($this->getMessage() . 'signUpException CLASS, line 16');
    }

}

class SignUpDatabaseException extends SignUpException {
    
}

class SignUpNotUniqueException extends SignUpException {
    
}

class SignUpEmailException extends SignUpException {
    
}

class SignUpConfirmationException extends SignUpException {
    
}

class Register {

    protected $errors = array(); 
    protected $regSuccess = false;

    public function __construct() {
        
    }

    public function registerUser($dbc, $fn, $ln, $u, $email, $p) {

        
        try {
          
            $q = "SELECT COUNT(*) AS how_many, email, username "
                    . "FROM users WHERE email=:email OR username=:username";

            $stmt = $dbc->prepare($q);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $u);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) { //this is DATABASE realted, so we catch it with PDOException()
            echo "<h1>REgister.php Line48</h1>";
            throw new SignUpDatabaseException('Database error when' . ' checking user is unique: ' . $e->getMessage());
        }


      
        if ($rows['how_many'] == 0) {
            
                     
            require './includes/password.php';
            $p = password_hash($p, PASSWORD_BCRYPT);

            try {
                
               
                $q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) "
                        . "VALUES (:u, :e, :password, :fn, :ln, ADDDATE(NOW(), INTERVAL 1 MONTH) )";

                $stmt2 = $dbc->prepare($q);
                $stmt2->bindParam(':u', $u);
                $stmt2->bindParam(':e', $email);
                $stmt2->bindParam(':password', $p);
                $stmt2->bindParam(':fn', $fn);
                $stmt2->bindParam(':ln', $ln);
                $result = $stmt2->execute();
                
            } catch (PDOException $e) {
                echo "<h3>catch PDOException line 83, Register</h3>";
                throw new SignUpDatabaseException('Database error when' . ' INSERTING user : ' . $e->getMessage());
            }


            if ($result) {
                $this->regSuccess = TRUE;                
            } else {                
                exit("str88, Error");
            }
        } else {
            
          
            if (($rows['email'] === $email) && ($rows['username'] === $u)) {
                $this->errors['email-username-taken'] = 'This email address AND username has already been registered. Please register with different credentials. ';
            } elseif ($rows['email'] === $email) {
                $this->errors['email-taken'] = 'This email address has already been registered. Please register with different credentials. ';
            } elseif ($rows['username'] === $u) {
               
                $this->errors['email-taken'] = 'This username has already been registered. Please register with different username. ';
            }
        }
    }

    public function getErrrors() {
        return $this->errors;
    }

}

?>