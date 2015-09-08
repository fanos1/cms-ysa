<footer class="container">    
    <div class="row">
        <div class="col-md-12">
            <ul id="footer">
                <?php    
                
                $q = "SELECT 
                    c.menu_display_name,
                    c.id
                    FROM categories AS c
                    INNER JOIN menu_categories AS mc ON mc.category_id = c.id
                    WHERE mc.menu_id = 2"; 
                
                
                $stmt = $dbc->query($q);              
                $r = $stmt->fetchAll(PDO::FETCH_ASSOC); 

                foreach ($r as $array) {                                            
                    echo '<li>'
                        . '<a href="/category.php?id=' .$array['id']. '">'                         
                            .htmlspecialchars($array['menu_display_name']) . 
                         '</a></li>';

                }
                if(isset($_SESSION['user_admin']) ) {
                    echo '<li><a href="logout.php">Log out</a></li>';
                } else {
                    echo '<li><a href="login.php">Admin</a></li>';
                }
                ?>                    
                <li><a href="register.php">Register</a></li>
            </ul>
            <div>&copy; YSA - Driving School</div>
        </div>
        
    </div>            
</footer>



<script type="text/javascript" src="/js/bootstrap.min.js"></script>            
<script>
   $(document).ready(function(){
       $('.dropdown-toggle').dropdown();
   });

   $('#hidecookiewarning').click(function() {
       $(this).toggleClass('clicked');
   });

</script>

</body>
</html>