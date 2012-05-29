<?php

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


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = get('webURL') . _sh . 'IMAGENES/clubes';

	/** DESCOMENTAR PARA LA VERSIÓN EN LÍNEA **/
	//$targetPath = str_replace("/loginAdministrador", "..", $targetPath);
	//$targetPath = "../../".$targetPath;

	$name = $_FILES['Filedata']['name'];
	$ext = explode(".",$name);				 		
	$id = date("YmdHis").rand(0,100).rand(0,100);
	$name = $id.".".$ext[1];
	
	$targetFile = $targetPath . $name;
		
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
	
	createThumbs($targetPath, $name, $targetPath."/thumbs/",200);
	
	$query = "insert into galeria values('$id','$name','$album','".date("Y-m-d")."','0')";
			mysql_query($query) or die(mysql_error());
}
echo "1";
?>