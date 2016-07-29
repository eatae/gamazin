<?php
function do_html_header($tit){
	$pageData = data_for_page($_SESSION['valid_user']);
	global $menu;
	$menu= getProducts();
	$json_menu = json_encode($menu);
	
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href='/style/style.css' rel='stylesheet' type='text/css'>
	<link href='https://www.google.com/fonts#ChoosePlace:select/Collection:Russo+One/Script:cyrillic'>
	<title><?=$tit?></title>
	<script src='js/leftMenu.js'></script>
	<?=$pageData[2]?>
	<script>
		function showItems(tit, /*optional*/anch){
			var menu = <?= $json_menu ?>;
			if(!menu) return;
			anch = anch || '';
			tit = (tit.innerHTML) ? tit.innerHTML : tit;
			var content = document.getElementById('content');

			/* если мы вставили в content блок с классом '.choice'
				то присвой name значение, если нет то присвой false */
			var name = 
					(document.querySelector('.choice')) ?  
					content.firstChild.nextSibling.firstChild.nextSibling.nextSibling.firstChild.nodeValue : 
					false;

			/* если ссылка (tit) содержит то же название, что и
				отображенный товар (т.е. второй раз кликаем по одному
				пункту) выходим из функции */
			if(tit == name){
				return;
			}
			/* затираем всё содержимое */
			content.innerHTML = '';

			/* заполняем заново */
			var choice = document.createElement('div');
			choice.setAttribute('class', 'choice')

			var anchor = document.createElement('a');

			var img = document.createElement('img');
			img.setAttribute('class', 'photo');

			var divName = document.createElement('div');
			divName.setAttribute('class', 'name');

			var button = document.createElement('div');
			button.setAttribute('class', 'button_choice');

			var a = document.createElement('a');
			var word = document.createTextNode('В корзину');
			a.appendChild(word);
			button.appendChild(a);

			//колбаса
			choice.appendChild(anchor);
			choice.appendChild(img);
			choice.appendChild(divName);
			choice.appendChild(button);


			for(var category in menu){
				var obj = menu[category][tit];

				for(var pr in obj){
					img.setAttribute('src', obj[pr]['img']);
					anchor.setAttribute('name', 'id_'+ obj[pr]['product_id']);
					a.setAttribute('href', "<?=$_SERVER['PHP_SELF']?>?basket="+obj[pr]['product_id']+"&tit="+obj[pr]['title']+"&cat="+obj[pr]['category']);

					//заполняем полностью divName
					divName.innerHTML = obj[pr]['title']+"<span class='price'>" + obj[pr]['price']+" кл</span>";
					content.appendChild(choice.cloneNode(true));
				}

			}

			if(anch) location.hash = anch;
		}// end showItems
	</script>
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
<!--
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