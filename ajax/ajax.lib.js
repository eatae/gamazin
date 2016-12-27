
var contentBlock,
    basket,
    request = getXMLHttpRequest();



/* добавляем обработчики при загрузки страницы */
window.addEventListener('load', commonEventListener);





/* ОБЩИЙ ОБРАБОТЧИК СОБЫТИЯ window.load */
//---------------------------------------


function commonEventListener(){
    contentBlock = document.getElementById('content');
    basket = document.getElementById('basket');

    /* ADMIN MENU */

    /* addEvent for button (span) in admin_menu (if exist) */
    var adminMenuSpan = document.querySelectorAll('#admin_menu span');

    /* adminMenuSpan - nodeList
       поэтому на null проверяем первый элемент */
    if ( null != adminMenuSpan[0] ) {

        /* добавляем обработчик кнопкам (js/adm_press_button)*/
        for ( var cnt=0; cnt < adminMenuSpan.length; cnt++ ) {
            adminMenuSpan[cnt].addEventListener( 'click', function(){ adm_press_button(this, adminMenuSpan) } );
        }

        /* click МЕНЮ АДМИНИСТРАТОРА */

        /* обработчик добавление товара */
        adminMenuSpan[0].addEventListener( 'click', getUploadsProduct );

        /* обработчик просмотра заказов при клике на админ меню */
        adminMenuSpan[1].addEventListener( 'click', function(){getPageForOrders(0)} );

        /* обработчик меню поиска */
        adminMenuSpan[2].addEventListener( 'click', getPageForSearch );

    }

}





/*===================*/
/*  АДМИН ПАНЕЛЬ    */
/*==================*/



    /*** ПОИСК ***/


/*      форма поиска
* - первая страница поиска
*/
function getPageForSearch()
{
    var url = '../ajax/adm_search.php';
    var ajaxSearch = document.getElementById('ajax_box_adminPanel');

    request.open('GET', url, false);
    request.send(null);
    ajaxSearch.innerHTML = request.responseText;

    example_forSearch();
}




/*      ПОДСКАЗКА В ФОРМЕ ПОИСКА
*/
function example_forSearch(){
    var selected = adm_select.selectedIndex;
    var placeholder = function(){
        /* смотрим какой options выбран - adm_select.options[0]...  */
        switch(selected) {
            case 0: return 'name@example.com'; break;
            case 1: return '123'; break;
            case 2: return '123'; break;
            case 3: return '22/12/2016'; break;
        }
    };
    document.querySelector( '#search_form input[type="text"]').setAttribute('placeholder', placeholder() );
}



/*      ВЫЗОВ ФУНКЦИИ ДЛЯ ПОИСКА
* */
function callForSearch()
{
    var inputText = document.querySelector("#search_form input[type='text']");
    inputText = ( null != inputText ) ? inputText.value : 'No';
    takeCustomerByEmail(inputText);
}










    /*** ЗАКАЗЫ ***/


/*      ПРОСМОТР ВСЕХ ЗАКАЗОВ
 *
 * - цепляем на кнопку 'заказы' (addEvent)
 *
 * pagination
 * - цепляем на click по номеру страницы (in html)
 *
 * back
 * - цепляем на кнопку 'назад' (in html)
*/
function getPageForOrders(event_or_num)
{
    /* проверяем object пришёл или number и присваиваем */
    var pageNumber = ( ('number' == typeof event_or_num) && (null == event_or_num.currentTarget) )
                        ? event_or_num : event_or_num.currentTarget.innerText;

    if ( 0 != pageNumber) { pageNumber--; }

    var url = '../ajax/adm_last_orders.php?page='+encodeURIComponent(pageNumber);
    var ajaxBox = document.getElementById('ajax_box_adminPanel');

    request.open('GET', url, false);
    request.send(null);
    ajaxBox.innerHTML = request.responseText;

    /* и ещё раз добавляем (pagination)
       обработчик просмотра заказов при клике на номер страницы */
    var num_page_orders = document.querySelectorAll('#num_page_orders span');
    if( null != num_page_orders[0] ) {
        for ( var count=0; count < num_page_orders.length; count++ ) {
            num_page_orders[count].addEventListener( 'click', function(e){ getPageForOrders(e) }, false );
        }
    }
}




function test(self){
    var cust_email = (function() {
        return self.parentNode.querySelector('.cust_email');
    })();
    cust_email = (null != cust_email) ? cust_email.innerText : '';
    console.log(cust_email);
}



/*      ПРОСМОТР ОДНОГО ЗАКАЗА
 *
 * - цепляем на click по номеру заказа (in html - ajax/adm_last_orders.php)
 *
 * @param double_return
 * - передаёт данные для двойного возврата с помощью 'НАЗАД' (пред-предыдущую страницу).
 */
function takeOrderByNumber(self, double_return)
{
    double_return = ( null != double_return) ? double_return : '';


    /* получаем cust_email для 'назад' со страницы инф. о покупателе */
    var cust_email = document.querySelector(".cust_email");
    cust_email = (null != cust_email) ? cust_email.innerText : '';


    /* получаем текст нажатой кнопки */
    var pressMenuText = document.querySelector('#admin_menu .adm_press_button').innerText;
    var ajaxBox = document.getElementById('ajax_box_adminPanel');
    var search = '';

    /* проверяем - 'не поиск ли нажат' (от этого зависит id блока для вставки ajax) и GET */
    if ('Поиск' == pressMenuText) {
        ajaxBox = document.getElementById('ajax_box_searchPanel');
        cust_email = document.querySelector("#search_form input[type='text']");
        cust_email = (null != cust_email) ? cust_email.value : '';
        search = true;
    }


    /* получаем номер открытой страницы для 'назад' */
    var page_num = document.querySelector('#num_page_orders .adm_press_button');
    page_num = ( null != page_num ) ? page_num.innerText : '';



    /* получаем id заказа */
    var order_num = self.innerText;

    var url = '../ajax/adm_last_orders_num_ord.php' +
                '?order_num=' + encodeURIComponent(order_num) +  //номер заказа для запроса
                '&page_num=' + encodeURIComponent(page_num) +    //для возврата в заказы
                '&double_return=' + encodeURIComponent(double_return) + //двойной возврат
                '&cust_email=' + encodeURIComponent(cust_email) + //для возврата в покупатели
                '&search=' + encodeURIComponent(search); //для возврата в покупатели


    request.open('GET', url, true);
    request.send(null);

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            ajaxBox.innerHTML = request.responseText;
        }
    };
}






/*      ПРОСМОТР ЗАКАЗЧИКА ПО email */

/* функцию цепляем в элементе (ajax/adm_last_orders.php)
*  всё немного заморочено - double_return передаёт данные для двойного
*  возврата с помощью 'НАЗАД' пред-предыдущую страницу
*/
function takeCustomerByEmail(object_or_string, double_return)
{
    double_return = ( null != double_return) ? double_return : '';
    //console.log(double_return);

    /* получаем текст нажатой кнопки */
    var pressMenuText = document.querySelector('#admin_menu .adm_press_button').innerText;
    var ajaxBox = document.getElementById('ajax_box_adminPanel');
    var search = '';

    /* проверяем - 'не поиск ли нажат' (от этого зависит id блока для вставки ajax) и GET */
    if ('Поиск' == pressMenuText) {
        ajaxBox = document.getElementById('ajax_box_searchPanel');
        search = true;
    }

    /* получаем номер открытой страницы для 'назад' */
    var page_num = document.querySelector('#num_page_orders .adm_press_button');
    page_num = (null != page_num) ? page_num.innerText : '';

    /* получаем email покупателя */
    var customerEmail = ( ('string' == typeof object_or_string) && ( 1 != object_or_string.nodeType) )
        ? object_or_string : object_or_string.innerText;

    var url = '../ajax/adm_last_orders_cust_mail.php' +
                    '?cust_email=' + encodeURIComponent(customerEmail) +
                    '&page_num=' + encodeURIComponent(page_num) +
                    '&double_return=' + encodeURIComponent(double_return) +
                    '&search=' + encodeURIComponent(search);


    request.open('GET', url, true);
    request.send(null);

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            ajaxBox.innerHTML = request.responseText;
        }
    };
}




/*** ДОБАВЛЕНИЕ ТОВАРА ***/

function getUploadsProduct()
{
    var url = '../ajax/adm_upload_product.php';
    var ajaxBox = document.getElementById('ajax_box_adminPanel');

    request.open('GET', url, false);
    request.send(null);
    ajaxBox.innerHTML = request.responseText;

    uploads_prod();

}









/*==============================*/
/*  ПОКАЗ ТОВАРА НА ГЛАВНОЙ    */
/*=============================*/



/*      main
*/
function get_Products(title)
{
    var url = 'ajax/ajax_select_products.php?title_name='+encodeURIComponent(title);

    request.open('GET', url, true);
    request.send(null);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            contentBlock.innerHTML = request.responseText;
        }
    }
}




function showProducts(title_name)
{
    title_name = title_name.innerHTML || '';
    // console.log(title_name);
    if(title_name != '')
        get_Products(title_name);
}





/*** ДОБАВЛЕНИЕ В КОРЗИНУ (in main) ***/

function basketFromMain(self)
{
    var id = self.getAttribute('name'),
        basket = document.getElementById('basket'),
        url = 'ajax/ajax_work_basket.php?action=main_add&data=' + id,
        checkBasket,
        cntBasket;


    request.open('GET', url, true);
    request.send(null);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            checkBasket = JSON.parse(request.responseText);
            cntBasket = checkBasket.count;
            basket.innerHTML = 'Корзина: ' + cntBasket;
        }
    }
}








/*=============*/
/*  КОРЗИНА   */
/*============*/




/*** ДОБАВЛЕНИЕ и УДАЛЕНИЕ (in basket) В КОРЗИНЕ ПОКУПАТЕЛЯ  ***/

function basketFromBasket(self)
{
    // получаем класс кнопки - del / add
    var buttonClass = self.getAttribute('class'),

        div = self.parentNode.parentNode,

        divCenter = document.getElementById('center');

        div_id = div.getAttribute('id'),

        div_price = div.querySelector('.prod_price'),
        price = parseInt(div_price.innerText),

        div_quantity = div.querySelector('.prod_quantity'),
        quantity = parseInt(div_quantity.innerText),

        div_sum = div.querySelector('.prod_sum'),
        sum = parseInt(div_sum.innerText),

        span_all_count = document.getElementById('all_count'),
        all_count = parseInt(span_all_count.innerText),

        span_all_sum = document.getElementById('all_sum'),
        all_sum = parseInt(span_all_sum.innerText),

        /* сумма для формы */
        hidden_all_sum = document.querySelector("input[name='sum']").value;


    if ( 'add' == buttonClass ) {
        url = 'ajax/ajax_work_basket.php?action=basket_add&data=' + div_id;
        ++quantity;
        sum = price * quantity;
        ++all_count;
        all_sum += price;
        hidden_all_sum = all_sum;
    }
    else if ( 'del' == buttonClass ) {
        url = 'ajax/ajax_work_basket.php?action=basket_del&data=' + div_id;
        --quantity;
        sum = price * quantity;
        --all_count;
        all_sum -= price;
        hidden_all_sum = all_sum;
        if(0 === quantity) {
            div.innerHTML = '';
            div.style.display = 'none';
        }
    }


    request.open('GET', url, true);
    request.send(null);

    request.onreadystatechange = function(){
        if( request.readyState == 4 && request.status == 200 )
        {
            // если удалили последний элемент корзины выводим:
            if( 0 === all_count ) {
                var string = 'Ваша корзина пуста'+
                                '<br><br><a href="javascript:history.back()">Назад</a>';
                divCenter.style.padding = '20px';
                divCenter.innerHTML = string;
            }
            else if( all_count == parseInt(request.responseText) ) {
                div_quantity.innerHTML = quantity;
                div_sum.innerHTML = sum + ' кл';
                span_all_count.innerHTML = all_count;
                span_all_sum.innerHTML = all_sum;
            }
        }
    }

}








/* ДАННЫЕ ПОЛЬЗОВАТЕЛЯ */
//----------------------


/*** ИЗМЕНЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЕМ ПРИ ЗАКАЗЕ (basketForm_u(c)) ***/

/* GET FORM FOR CHANGE */

function get_form_change_data()
{
    var divSubmit = document.querySelector('div.inner_block_right');
    var url = 'ajax/changeUser_inOrder_getForm.php';

    request.onreadystatechange = function(){
        if( request.readyState === 4 && request.status == 200 ) {
            divSubmit.innerHTML = request.responseText;
        }
    };

    request.open('GET', url, true);
    request.send(null);
}



/* CHANGE USER or CUSTOMER DATA */

function change_user_data()
{
    var innerBlockRight = document.querySelector('div.inner_block_right');
    var url = 'ajax/changeUser_inOrder.php';
    var stringPost;

    var email = innerBlockRight.querySelector("input[name='email']").value;
    var pass = innerBlockRight.querySelector("input[name='password']").value;
    /* Узлы которых может не быть на странице */
    var name = innerBlockRight.querySelector("input[name='name']");
    if ( null != name ) {
        name = name.value;
    }
    var phone = innerBlockRight.querySelector("input[name='phone']");
    if ( null != phone ) {
        phone = phone.value;
    }

    request.onreadystatechange = function(){
        if(request.readyState != 4 && request.status != 200) {
            return;
        }
        innerBlockRight.innerHTML = request.responseText;
    };

    request.open('POST', url, true);

    stringPost = 'email=' + email +
                '&name=' + name +
                '&phone=' + phone +
                '&password=' + pass;

    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(stringPost);


}





