<?php

class Categories {
    
    public $id = null;
    public $publicationDate = null;
    public $title = null;
    public $excerpt = null;    
    public $content = null;



    //public function __construct($db_conn) {
    public function __construct() {
        
    }
    
    
    public static function getAllCategories($dbc) {
        try {                        
            $q = "SELECT id, title, content FROM categories";
            
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;            
            
        } catch (PDOException $e) {
          
            echo "<h3>nothing returned, or database related error</h3>";
        }
    }
    
    

    public static function getArticlesByCategory($dbc, $catId) {
        try {           
            
            echo '<h3>'.$catId.'</h3>';
                    
            $q = "SELECT a.id, a.title, a.content "
                    . "FROM articles AS a "
                    . "INNER JOIN articles_categories AS ac ON ac.article_id = a.id "
                    . "INNER JOIN categories AS c ON c.id = ac.category_id "
                    . "WHERE ac.category_id = $catId";
                        
            $stmt = $dbc->query($q);            
            $r = $stmt->fetchAll();            
            return $r;            
            
        } catch (PDOException $e) {
           
            echo "<h3>nothing returned, or database related error</h3>";
        }
    }
  
 
    
}
?>
