<?php

class Articles {
    
    public $id = null;
    public $publicationDate = null;
    public $title = null;
    public $excerpt = null;    
    public $content = null;
   


    //public function __construct($db_conn) {
    public function __construct() {
        
    }
    
    
    public static function getAllArticles($dbc) {
        try {                        
            $q = "SELECT id, title, content FROM articles";            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;                        
        } catch (PDOException $e) {            
                     
        }
    }
    
    public static function getFrontPageArticles($dbc) {
        try {                        
            $q = "SELECT id, title, content, img 
                    FROM articles 
                    INNER JOIN articles_categories AS ac ON articles.id = ac.article_id
                    WHERE ac.category_id = 1";
            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;            
            
        } catch (PDOException $e) {
                    
        }
    }
    
    
  
    public static function getArticleById($dbc, $articleId) {
        try {            
            
            $q = "SELECT id, title, content, img 
                    FROM articles 
                    INNER JOIN articles_categories AS ac ON articles.id = ac.article_id
                    WHERE ac.article_id = $articleId";
            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;            
            
        } catch (PDOException $e) {
         
            echo "<h3>nothing returned, or database related error</h3>";
        }
    }
    
  
    public static function getArticlesByCategory($dbc, $catId) {
        try {            
            
            $q = "SELECT id, title, content 
                    FROM articles 
                    INNER JOIN articles_categories AS ac ON articles.id = ac.article_id
                    WHERE ac.category_id = $catId";
            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;            
            
        } catch (PDOException $e) {
          
            echo "<h3>nothing returned, or database related error</h3>";
        }
    }
    
    
    public static function get3RandArticles() {        
        $list = array();
        try {
            $q = "SELECT id, title, LEFT(content, 150) AS excerpt, img, date_created
			FROM articles
			WHERE date_created BETWEEN DATE_ADD(NOW() , INTERVAL -1 WEEK ) AND NOW() 
			ORDER BY RAND()
			LIMIT 0 , 3";
            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;   
         
        } catch (PDOException $e) {
           
                      
        }
    }
    
}
?>
