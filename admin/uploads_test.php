<pre>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		print_r($_FILES);
		
		$tmp = $_FILES['userfile']['tmp_name'];
		$name = $_FILES['userfile']['name'];
		move_uploaded_file($tmp, '../img/'.$name);
		if(!$e){
			echo __DIR__;
//			echo $tmp;
		}
	}
?>
<form action='#' enctype='multipart/form-data' method='POST'>
	<input name='userfile' type='file'/>
	<input type='submit'/>
</form>