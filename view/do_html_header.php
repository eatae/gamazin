<?php
//echo '<pre>';
function do_html_header($tit){
	$pageData = data_for_page($_SESSION['valid_user']);
	
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href='/style/style.css' rel='stylesheet' type='text/css'>
	<link href='https://www.google.com/fonts#ChoosePlace:select/Collection:Russo+One/Script:cyrillic'>
	<title><?=$tit?></title>
	<script src='js/leftMenu.js'></script>
	
	<!-- AJAX -->
	<script type='text/javascript' src='ajax/xmlHttpRequest.js'></script>
	<script type='text/javascript'>
		var contentBlock,
		request = getXMLHttpRequest();
		window.onload = function(){
			contentBlock = document.getElementById('content');
			console.log(contentBlock);
		}
		function get_Products(title){
			var url = 'ajax/ajax_select_products.php?title_name='+title;
			request.open('GET', url, true);
			request.send(null);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					contentBlock.innerHTML = request.responseText;
				}
			}
		}
		function showProducts(title_name){
			title_name = title_name.innerHTML || '';
			console.log(title_name);
			if(title_name != '')
				get_Products(title_name);
		}
	</script>
	<!-- END AJAX -->
	
	<!-- tag <script> for upload_products -->
	<?=$pageData[2]?>
</head>

<body>
	<div id='wrapper'>
<!--	<img id='grid' src="img/marking/grid_5px.png">-->
		<div id='outer'>
			<div class='indent'></div>
			
			<!--HEADER-->
			<div id='header'>
				<img src='/img/marking/header.jpg'/>
			</div>
			
			<!--TOP-->
			<div id='top'>
				<!--TOP MENU-->
				<div id='topmenu'>
					<ul>
						<li><a href='<?=$pageData[3]?>index.php' class='active' href='#'>Почемучто</a></li>
						<li><a href='#'>Отзывы</a></li>
						<li><a href='#'>Контакты</a></li>
					</ul>
					<?=$pageData[1]?>
					<!-- this form in $pageData[1] --
					<form method="post">
						<input type='text' class='pl' name='login'>
						<input type='password' class='pl' name='pass'>
						<input type='image' src='/img/marking/transparence.png'>
					</form>
					<form method="post">
						<input type='image' src='/img/marking/transparence.png'>
					</form>
					-->
					
				</div>
			</div>

<?php
} /*end function*/
?>