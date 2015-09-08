<?php

class Login {

    //protected $logInSuccess = false;
    private $userId;
    private $logInSuccess = false;
    private $adminUser = false;

    public function __construct() {
             
    }

    public function loginUser($dbc, $email, $p) {

        try {

            $q = "SELECT COUNT(*) AS how_many, id, pass, type FROM users WHERE email='$email'";          
            $stmt = $dbc->prepare($q);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

           
            if ($row['how_many'] == 1) { 
                include('./includes/password.php');
                if (password_verify($p, $row['pass'])) {

                    if ($row['type'] === 'admin') {
                        session_regenerate_id(true); 
                      
                        $this->adminUser = TRUE;
                    }

                   
                    $this->userId = $row['id'];
                    $this->logInSuccess = TRUE;
                }
            }
        } catch (PDOException $e) {
           
            echo "<h3>nothing returned, or database related error</h3>";
        }
    }

    public function getUserId() {
        return $this->userId;
    }

    public function isLogedIn() {
        return $this->logInSuccess;
    }

    public function isUserAdmin() {
        return $this->adminUser;
    }

}
?>



