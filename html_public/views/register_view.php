<?php
require_once('./includes/functions.php');

if (isset($regErr) && !empty($regErr)) {
    foreach ($regErr as $k => $v) {
        echo '<h3>' . $v . '</h3>';
    }
}


?>



<div class="container">
    <div class="row">
        <div class="col-md-12">        
<?php 
if ($showForm) {  ?>

                <h1>Register</h1>
                <form action="register.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="token" value="<?php echo $token; ?>" />    
                    <p class="hp" style="display: none;"> <input type="text" name="med" value=""> </p>

                    <?php
                    create_form_input('first_name', 'text', 'First Name', $valid_errors, array('placeholder'=>'Fist Name') );
                    create_form_input('last_name', 'text', 'Last Name', $valid_errors, array('placeholder'=>'Last Name') );
                    create_form_input('username', 'text', 'Desired Username', $valid_errors, array('placeholder'=>'Username - Only letters and numbers allowed'));
					 //echo '<span class="help-block">Only letters and numbers are allowed.</span>';
                    create_form_input('email', 'email', 'Email Address', $valid_errors, array('placeholder'=>'Email address') );
                    create_form_input('pass1', 'password', 'Password', $valid_errors, array('placeholder'=>'Password - Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.'));
					 //echo '<span class="help-block">Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</span>';
                    create_form_input('pass2', 'password', 'Confirm Password', $valid_errors, array('placeholder'=>'Retype Password') );
                    ?>
                    <input type="submit" name="submit_button" value="Next &rarr;" id="submit_button" class="btn btn-default" />
                </form>

    <?php
} else { 
    echo '<div class="alert alert-success"><h3>Thanks!</h3><p>Thank you for registering! You may now log in and access the site\'s content.</p></div>';
    echo '<div><a href="./login.php">Log in page</a></div>';
}
?>

        </div>        
    </div>
</div>

