<?php
$_SESSION['token'] = md5(uniqid(rand(), true));
$token = htmlspecialchars($_SESSION['token']);
    
if (!isset($login_errors)) { 
    $login_errors = array();
}
require(ROOT.'/includes/functions.php');
?>

<!-- <form action="" method="post" accept-charset="utf-8">  -->
<form action="login.php" method="post" accept-charset="utf-8">  
    <input type="hidden" name="token" id="formtoken" value="<?php echo $token; ?>" />
    <p class="hp" style="display: none;"> <input type="text" name="med" id="med" value=""> </p>

    <fieldset>
            <legend>Admin Login</legend>
            <?php 
            if (array_key_exists('login', $login_errors)) {
                echo '<div class="alert alert-danger">' . $login_errors['login'] . '</div>';
            }
            create_form_input('email', 'email', '', $login_errors, array('placeholder'=>'Email address')); 
            create_form_input('pass', 'password', '', $login_errors, array('placeholder'=>'Password')); 
            echo '<span class="help-block"><a href="forgot_password.php">Forgot?</a></span>';
            ?>
        <button type="submit" class="btn btn-default">Login &rarr;</button>
    </fieldset>
</form>	


