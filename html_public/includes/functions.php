<?php
//Function taken from PHP and MySQL for Dynamic Web Sites Visual QuickPro Guide
// This function generates a form INPUT or TEXTAREA tag.
function create_form_input($name, $type, $label = '', $errors = array(), $options = array() ) {
	
	$POSTED = false;
	
	if (isset($_POST[$name])) {
            $POSTED = $_POST[$name];
        }            
	
	if ($POSTED && get_magic_quotes_gpc()) $POSTED = stripslashes($POSTED);
	echo '<div class="form-group';
	if (array_key_exists($name, $errors)) echo ' has-error';
	echo '">';
	if (!empty($label)) echo '<label for="' . $name . '" class="control-label">' . $label . '</label>';
	if ( ($type === 'text') || ($type === 'password') || ($type === 'email')) {	
		echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control"';
		if ($POSTED) {
			echo ' value="' . htmlspecialchars($POSTED) . '"';
		} 		
                  
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";                                
			}
		}
                 				
		echo '>';
		if (array_key_exists($name, $errors)) echo '<span class="help-block">' . $errors[$name] . '</span>';

	} elseif ($type === 'textarea') { 
		if (array_key_exists($name, $errors)) echo '<span class="help-block">' . $errors[$name] . '</span>';
		echo '<textarea name="' . $name . '" id="' . $name . '" class="form-control"';
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		}
		
		echo '>';		
		
		
		if ($POSTED) echo $POSTED;

		
		echo '</textarea>';
		
	}
		
	echo '</div>';

} 
?>
