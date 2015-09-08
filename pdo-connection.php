<?php
//The Front End of the website is using PDO connection,
//and the /admin/ side of the site is using mysqli
DEFINE ('DB_USER', 'ysadrivi_sam422');
DEFINE ('DB_PASSWORD', 'LswqdDbnm23!yu');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'ysadrivi_sam');
DEFINE ('DB_DSN', 'mysql:host=localhost;dbname=ysadrivi_sam');


//db connection class using singleton pattern
//http://weebtutorials.com/2012/03/pdo-connection-class-using-singleton-pattern/
class dbConn {
	
	protected static $dbc;
	
	private function __construct() {	
		try {
			self::$dbc = new PDO( DB_DSN, DB_USER, DB_PASSWORD );			
			self::$dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e) {			
			exit('Connection Error: We apologise');
		}
	
	}
		
	public static function getConnection() {	
	
		if (!self::$dbc) {
		//new connection object.
			new dbConn();
		}
		
		//return connection.
		return self::$dbc;
	}

} 
?>