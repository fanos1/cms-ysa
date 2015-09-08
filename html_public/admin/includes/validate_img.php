
<?php


if(is_uploaded_file($_FILES['imgfile']['tmp_name']) && ($_FILES['imgfile']['error'] == UPLOAD_ERR_OK) )  
{                                                        

    $size = ROUND($_FILES['imgfile']['size']/1024);
    if ($size > 1024) { 
        $imgErrors['img_size'] = '<div class="alert alert-danger">The uploaded file was too large.</div>';         
    }

    $allowed_mime = array ('image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');                    
    $allowed_extensions = array ('.gif', '.GIF', '.png', '.PNG', '.jpg', '.JPG', 'jpeg');

    $imgInfo = getimagesize($_FILES['imgfile']['tmp_name']);                         
    $ext = substr($_FILES['imgfile']['name'], -4); 

   
    if( (!in_array($_FILES['imgfile']['type'], $allowed_mime) ) 
            || (!in_array($imgInfo['mime'], $allowed_mime) ) 
                || (!in_array($ext, $allowed_extensions) ) ) 
    {
        $imgErrors['img_notvalid'] = '<div class="alert alert-danger">The uploaded file was not of the proper type.</div>';
    } 

    if(isset($imgErrors) && empty($imgErrors)) 
    {
                             
        if ($imgInfo['mime'] === "image/gif") {
            $original_image = imagecreatefromgif($_FILES['imgfile']['tmp_name']);                      
        } 
        elseif ($imgInfo['mime'] === "image/png") {                    
            $original_image = imagecreatefrompng($_FILES['imgfile']['tmp_name']);                                        
        } 
        elseif ($imgInfo['mime'] === "image/jpeg") {                    
            $original_image = imagecreatefromjpeg($_FILES['imgfile']['tmp_name']);
        }                    

        if(!$original_image) { 
            die("System Error occured, we apologize. str149");
        }

      

        //Algorithm taken from: http://stackoverflow.com/questions/1855996/crop-image-in-php
        $original_aspect = $imgInfo[0] / $imgInfo[1];
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect ) {                   
           $new_height = $thumb_height;
           $new_width = $imgInfo[0] / ($imgInfo[1] / $thumb_height);                   
        } else {
           $new_width = $thumb_width;
           $new_height = $imgInfo[1] / ($imgInfo[0] / $thumb_width);
        }

        $canvas = imagecreatetruecolor( $thumb_width, $thumb_height );

        if( imagecopyresampled($canvas, $original_image,
            0 - ($new_width - $thumb_width) / 2,// Center the image horizontally
            0 - ($new_height - $thumb_height) / 2,// Center the image vertically
            0, 0,
            $new_width, $new_height, $imgInfo[0], $imgInfo[1] ) )                           
        {
                        
            $newImgName = (string) md5($_FILES['imgfile']['name'] . uniqid('',true) ); 

          
            $img = $newImgName.'.jpg'; 
            
            $imgNameAndDest = IMAGE_DIR."$newImgName".".jpg";  
           
            if(!imagejpeg($canvas, $imgNameAndDest, 90) ) {
                exit("<h3>A system error occured, we apologize, str212</h3>"); 
            }
                     
            imagedestroy($original_image); 
            imagedestroy($canvas);                                                                 
        } 


    } 

}   
                   
else 
{                     
    switch ($_FILES['imgfile']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $imgErrors['image_big'] = '<div class="alert alert-danger">The uploaded file was too large.</div>';
            break;
        case UPLOAD_ERR_PARTIAL:
            $imgErrors['partial_upload'] = '<div class="alert alert-danger">The file was only partially uploaded.</div>';
            break;                    
        case UPLOAD_ERR_EXTENSION:
            $imgErrors['system_error'] = '<div class="alert alert-danger">The file could not be uploaded due to a system error, PHP extension stopped the file upload.</div>';
            break;
        case UPLOAD_ERR_NO_FILE:
        default: 
            $imgErrors['no_file_uploaded'] = '<div class="alert alert-danger">No image file was uploaded.</div>';
            break;
    }
}


?>