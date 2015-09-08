<?php

//this file is outside HTML PUBLIC for security reason
DEFINE ('DB_USER', 'your db user name');
DEFINE ('DB_PASSWORD', 'your Db password');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'xxxx');
DEFINE ('DB_DSN', 'mysql:host=localhost;dbname=xxxx');



$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(!$dbc || mysqli_connect_errno() ) {
	exit("<h3>Error with database connection, we aplogise</h3>");
}

mysqli_set_charset($dbc, 'utf8');


function escape_data ($data, $dbc) {    
    if (get_magic_quotes_gpc() ) $data = stripslashes($data);
    return mysqli_real_escape_string ($dbc, trim ($data));	
}
?>