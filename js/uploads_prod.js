

/* this function call in ajax.lib.js - addEvent window load  */

function uploads_prod(){
		
		//получаем все элементы для клика
		var allTtle = document.querySelectorAll('.title');

		/* TEST */

		//добавляем всем элементам событие click
		for (var key in allTtle){
			if(allTtle[key].nodeType == 1)
				allTtle[key].addEventListener('click', clickTtle);
		}
		
		
		//вставить элемент после
		function insertAfter(elem, refElem){
			var parent = refElem.parentNode;
			var next = refElem.nextSibling;
			if(next){
				return parent.insertBefore(elem, next);
			}else {
				return parent.appendChild(elem);
			}
		}
	
	
		//проверить есть ли здесь (где клик) форма ввода
		function existEnterForm(elem){
			if(elem.parentNode.lastChild.previousSibling.getAttribute('class') == 'form')
				return elem.parentNode.parentNode.lastChild.previousSibling;
			else{return false}
		}
		
		
///////////////////////////////////
		//добавление элементов формы по клику
		function clickTtle(){
				//узлы c this
				var nameCatg = this.parentNode.parentNode.firstChild.nextSibling.innerHTML,
					nameTtle = this.firstChild.nodeValue,
					submenu = this.parentNode,
					node;


			//инициализируем переменные с узлами
				var p = document.createElement('p');
				br1 = document.createElement('br'),
				br2 = document.createElement('br'),
				br3 = document.createElement('br'),
				br4 = document.createElement('br'),
				price = document.createTextNode('Цена:  '),
				image = document.createTextNode('Изображение:  ');
				p.setAttribute('class', 'form');

			//input hidden category
				var inputCatg = document.createElement('input');
				inputCatg.setAttribute('class', 'button');
				inputCatg.setAttribute('type', 'hidden');
				inputCatg.setAttribute('name', 'category');
				inputCatg.setAttribute('value', nameCatg);
			//input hidden title
				var inputTtle = document.createElement('input');
				inputTtle.setAttribute('class', 'button');
				inputTtle.setAttribute('type', 'hidden');
				inputTtle.setAttribute('name', 'title');
				inputTtle.setAttribute('value', nameTtle);
			//input text (price)
				var inputPrice = document.createElement('input');
				inputPrice.setAttribute('type', 'text');
				inputPrice.setAttribute('name', 'price');
				inputPrice.setAttribute('size', '6');
			//input file (image)
				var inputImage = document.createElement('input');
				inputImage.setAttribute('type', 'file');
				inputImage.setAttribute('name', 'img');
			//кнопка submit
				var button = document.createElement('input');
				button.setAttribute('type', 'submit');
				button.setAttribute('value', 'Отправить');


			//КОЛБАСА
				p.appendChild(inputCatg);
				p.appendChild(inputTtle);
				p.appendChild(price);
				p.appendChild(inputPrice);
				p.appendChild(br1);
				p.appendChild(br2);
				p.appendChild(image);
				p.appendChild(inputImage);
				p.appendChild(br3);
				p.appendChild(br4);
				p.appendChild(button);


			//сама форма, если уже есть
				pForm = document.querySelector('.form');
			//лежит ли форма в этом же элементе 
				nForm = existEnterForm(this);

			//если pForm есть стираем его
				if(pForm)
					pForm.parentNode.removeChild(pForm);

			//если здесь форма то не создаём (стирается верхним условием)
				if(!nForm)
					insertAfter(p, this);

			}//end clickTtle
	};