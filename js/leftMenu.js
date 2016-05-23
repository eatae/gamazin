/*var menu, 
	submenu, 
	allBla;
		
		
/******* FUNCTION TOGGLE *******/
// плавное открытие-закрытие меню
// присваеваем событие с этой функцией при загарузке страници
		
		function toggle(){
			var thisBla = this.nextSibling.nextSibling.firstChild.nextSibling,
			thisBlaMargin = parseInt(thisBla.style.marginTop),
			thisBlaHeight = thisBla.offsetHeight;
			
			
			function smoothOpen(){
				thisBlaMargin += 10;
				thisBla.style.marginTop = thisBlaMargin + 'px';
				if(thisBlaMargin >= 0){
					clearInterval(open);
					thisBla.style.marginTop = '0';
				}
			};
			
			function smoothClose(){
				thisBlaMargin -= 10;
				thisBla.style.marginTop = thisBlaMargin + 'px';
				if((Math.abs(thisBlaMargin)) >= thisBlaHeight){
					clearInterval(close);
					thisBla.style.marginTop = '-' + thisBlaHeight +'px';
				}
			};
			
			/* если margin-top не равен '0px', делаем плавно '0px' */
			if(thisBlaMargin){ //ждём либо число, либо 0.
				var open = setInterval(smoothOpen, 20);
			}else{
				var close = setInterval(smoothClose, 20);
			};					
		
		}  
		
		
		
/******* CLOSE MENU *******/
// закрытие submenu на его же размер (используем при загрузке DOM)
		
		function closeMenu(divs){
			for(i=0; i<divs.length; i++){
				divs[i].style.marginTop = '-' + divs[i].offsetHeight  + 'px';
			}
		}


/******* FUNCTION SEARCH GET *******/
//разбираем строку запроса (URI) (get параметры)
		function searchGet(){
			var tmp = [];
			var tmp2 = [];
			var param = [];
			var get = location.search;
	
			if(get !== ''){
				tmp = (get.substr(1)).split('&');
				for(var i=0; i<tmp.length; i++){
					tmp2 = tmp[i].split('=');
					param[tmp2[0]] = tmp2[1];
				}
				return decodeURI(param['cat']);
			}
			return '';
		}
		
		
		
/******* FUNCTION BINDREADY *******/	
// загрузка DOM (кроссбраузерно)
		
		function bindReady(handler){
			var called = false;
			
			function ready(){
				if(called) return;
				called = true;
				handler();
			}
			
			if(document.addEventListener){
				document.addEventListener('DOMContentLoaded', ready, false)
			// IE
			}else if(document.attachEvent){
				try{
					var isFrame = window.frameElement != null;
				}catch(e){}
				
				if(document.documentElement.doScroll && !isFrame){
					function tryScroll(){
						if(called) return;
						try{
							document.documentElement.doScroll('left');
							ready();
						}catch(e){
							setTimeout(tryScroll, 10);
						}
					}
					tryScroll();
				}
			}
			// old browser
			if(window.addEventListener)
				window.addEventListener('load', ready, false);
			else if(window.attachEvent)
				window.attachEvent('onload', ready);
			else{
				var fn = window.onload;
				window.onload = function(){
					fn && fn();
					ready();
				}
			}
		}
		
		
		
/******* FUNCTION ADDEVENT *******/
// добавление события (кроссбраузерно)
		
		function addEvent(el, e, handler){
			if(el.addEventListener){
				el.addEventListener(e, handler);
			}else if(element.attachEvent){
				el.attachEvent('on' + e, handler);
			}else{
				el['on' + e] = handler;
			}
		}
		
			
/******* FUNCTION HANDLEREVENT *******/
// обработчик для DOMContentLoaded
		
		function handlerEvent(){
			
			var menu = document.querySelectorAll('p.out'),
			submenu = document.querySelectorAll('div.submenu a'),
			allBla = document.querySelectorAll('div.bla'),
			
			// 
			div = '',
			divMargin = '',
			divOpen = '';
			
			// получаем параметр строки get
			var get = searchGet();
			// закрываем меню
			closeMenu(allBla);
			
			/* бежим и добавляем событие пункту меню,
			   сравниваем строку get на наличие,
			   если совпадает значит добавляли в корзину,
			   открываем нужный пункт */
			for(i=0; i<menu.length; i++){
				addEvent(menu[i], 'click', toggle); //добав. событие на click
				if(get && menu[i].innerHTML == get) { // сравниваем с get
					div = menu[i].nextSibling.nextSibling.firstChild.nextSibling;
					divMargin = parseInt(div.style.marginTop);
					divOpen = setInterval(divSmoothOpen, 10); // откр после добав товара
				}
			}
			
			function divSmoothOpen(){
				divMargin += 10;
				div.style.marginTop = divMargin + 'px';
				if(divMargin >= 0){
					clearInterval(divOpen);
					div.style.marginTop = '0';
				}
			};
		}
		
		
/******* DOMContentLoaded *******/
		bindReady(handlerEvent);
		