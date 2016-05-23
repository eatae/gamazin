function showItems(tit, /*optional*/anch){
		anch = anch || '';
		console.log(anch);
		var menu = <?= $json_menu ?>;
		tit = (tit.innerHTML) ? tit.innerHTML : tit;
		console.log(tit);
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
				a.setAttribute('href', "<?=$_SERVER['PHP_SELF']?>?basket="+obj[pr]['product_id']+"&tit="+obj[pr]['title']);
				
				//заполняем полностью divName
				divName.innerHTML = obj[pr]['title']+"<span class='price'>" + obj[pr]['price']+" кл</span>";
				content.appendChild(choice.cloneNode(true));
			}
			
		}
		
		if(anch) location.hash = anch;
}// end function