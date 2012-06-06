<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

function createThumbs( $pathToImages, $image, $pathToThumbs, $thumbWidth ) 
{
    $info = pathinfo($pathToImages . $image);
   
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      $img = imagecreatefromjpeg( "{$pathToImages}{$image}" );
      $width = imagesx( $img );
      $height = imagesy( $img );
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
      imagejpeg( $tmp_img, "{$pathToThumbs}{$image}" );
    }
}
// Define a destination
$tipo = $_POST['tipo'];
$club = $_POST['club'];
$album = $_POST['album'];
$targetFolder = '/Dropbox/extraescolares/IMAGENES/clubes/'.$club.'/'.$album.'/'; // Relative to the root 
mysql_connect("localhost","root","");
mysql_select_db("extraescolares");

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];

	$name = $_FILES['Filedata']['name'];
	$ext = explode(".",$name);				 		
	$id = date("YmdHis").rand(0,100).rand(0,100);
	$name = $id.".".$ext[1];

	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $name;
	
		// Validate the file type
	$fileTypes = array('jpg','jpeg','JPG','JPEG'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	  
	if (in_array($fileParts['extension'],$fileTypes)) {
	    move_uploaded_file($tempFile,$targetFile);
	    createThumbs($targetPath, $name, $targetPath."/thumbs/",200);
	    $query = "insert into galeria values('$id','$name','$album','".date("Y-m-d")."','1','')";
	    mysql_query($query) or die(mysql_error());
	    echo '1';
	  } else {
	    echo 'Invalid file type.';
	  }
}
?>