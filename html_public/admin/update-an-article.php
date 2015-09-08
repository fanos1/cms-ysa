<?php
require('../includes/config.inc.php');
redirect_invalid_user('user_admin');
require(MYSQLi);

$errors = array();
$displayForm = TRUE; 
$htmlOutput = '';

if ( filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1)) )  {
        
    $q = 'SELECT id, title, content, menu_display_name 
          FROM articles WHERE id=' . $_GET['id'];
   
    
    $r = mysqli_query($dbc, $q);
    if (mysqli_num_rows($r) !== 1) { 
        $error_page_title = 'Error!';
        $htmlOutput .= '<div class="alert alert-danger">This page has been accessed in error.</div> ';
        
    } else {
        list($id, $title, $content, $menu_disp_name) = mysqli_fetch_array($r);
        mysqli_free_result($r);
    }

    $displayForm = TRUE;
} else {
    trigger_error('system error. Our sincere apologize, str42!');
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit_button'])) {

        if (!empty($_POST['content'])) {
            $allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote><table><tr><td>';
            $cleanCont = strip_tags($_POST['content'], $allowed);            
        } else { 
            $errors['content'] = '<div class="alert alert-danger">Please enter the content!</div>';            
        }

        if (!empty($_POST['title'])) {
            $cleanTitle = strip_tags($_POST['title']);
        } else {
            $errors['title'] = '<div class="alert alert-danger">Please enter title!</div>';
        }

        if (!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $cleanArticleId = strip_tags($_POST['id']);
        } else {
            $errors['id'] = '<div class="alert alert-danger">An error occured, we aplogize, try again!</div>';
        }

        if (!empty($_POST['menu_disp_name'])) {        
            $cleanMenuDispName = strip_tags($_POST['menu_disp_name']);
        } else {
            $errors['menu_disp_name'] = '<div class="alert alert-danger">Menu Display Name Error! Only strings allowed</div>';
        }

        if (empty($errors)) {            
            
           
            $stmt = mysqli_prepare($dbc, "UPDATE articles SET title=?, content=?, menu_display_name=? WHERE id=?");            
                                            
            
            if ($stmt ) {
                                
                if( mysqli_stmt_bind_param($stmt, 'sssi', $cleanTitle, $cleanCont, $cleanMenuDispName, $cleanArticleId) ) { 
                    
                    if( !mysqli_stmt_execute($stmt) ) { trigger_error('Problem withe database'); } 
                    
                    $rowEfeected = mysqli_stmt_affected_rows($stmt);
                    
                    if ($rowEfeected == 1) {
                        $htmlOutput .= '<div class="alert alert-success"><h3>The articles has been updated!</h3></div>';                                                         

                        $displayForm = FALSE;
                        $htmlOutput .= '<p><a href="./update-articles.php">Back to update all article article</a></p>';                         
                    } else if($rowEfeected == 0) { 
                        $htmlOutput .= '<div class="alert alert-danger"><h3>No data was updated in the database! please make sure you input the correct data types for each fields</h3></div>';                          
                    } else {
                        trigger_error('The page could not be added due to a system error. Our sincere apologize!');               
                    }
                    
                } else {
                    trigger_error('The Bind failed, str140');               
                    exit("<h3>BIND FAILED</h3>");                    
                }
                
            }
            
        }
    }
}

foreach ($errors as $k => $v ) {    
    $htmlOutput .= $v;
}




if(isset($error_page_title) && !empty($error_page_title)) {      
    $page_title = $error_page_title;
} else {
    $page_title = 'A list of articles you can update';
}


include('./includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $htmlOutput; ?>
        </div>
    </div>
</div>


<?php
if ($displayForm) { 
      
    echo '
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="" method="post" accept-charset="utf-8">    
                    <fieldset>
                        <legend>Update the content of this page</legend>                    

                        <div class="form-group">
                            <label for="title" class="control-label">Article Title</label>
                            <input type="text" name="title" value="' . htmlentities($title) . '" id="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="content" class="control-label">Article Content</label>
                            <textarea name="content" id="content" class="form-control">' . htmlentities($content) . '</textarea>
                        </div> 
                        

                        <div class="form-group">
                            <label for="menu display name" class="control-label">Menu Display Name - How should this article appear on the Menu Bar?</label>
                            <input type="text" name="menu_disp_name" value="' . htmlentities($title) . '" id="menu_disp_name" class="form-control">
                        </div>

                        <input type="hidden" name="id" value="' . htmlentities($id) . '" /> 
                            

                        <input type="submit" name="submit_button" value="Update this page" id="submit_button" class="btn btn-default" />	
                    </fieldset>        
                </form>
            </div>
        </div>
    </div>
    ';
}
?>

<!-- 
We will use TinyMCE for our WYSIWYG editor. This editor is written in JavaScript, and are open source, it has a lot of plug-in as well.
First, you will need to install it, see the docuemntation.
TinyMCE can make it easy to create styled and formatted HTML, containing any valid tags... 
It can also make it easy to add any kind of media, suchs as video.
However, TinyMCE require plug-in, created by same company, to manage file uploading. In this website we don't use that functionality.
--> 

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

    tinyMCE.init({
        // options
        selector: "#content",
        width: 800,
        height: 400,
        browser_spellcheck: true,
        //the plug-ins to use, enable only some of them
        //plugins: "paste,searchreplace,fullscreen,hr,link,anchor,image,charmap,media,autoresize,autosave,contextmenu,wordcount",
        plugins: "paste,searchreplace,fullscreen,hr,link,anchor,image,table,autoresize,autosave,contextmenu",
       
        toolbar1: "cut,copy,paste,|,undo,redo,removeformat,|hr,|,link,unlink,anchor,image,|,charmap,media,|,search,replace,|,fullscreen",
        toolbar2: "bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignjustify,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,",

        content_css: "css/bootstrap.min.css",
    });
</script>


<?php include('./includes/footer.php'); ?>