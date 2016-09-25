var contentBlock,
    request = getXMLHttpRequest();




window.onload = function(){
    contentBlock = document.getElementById('content');
    basket = document.getElementById('basket');

};




/*** ВЫВОД ТОВАРА ***/

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





/*** ДОБАВЛЕНИЕ и УДАЛЕНИЕ В КОРЗИНУ (in basket) ***/

function basketFromBasket(self)
{
    var buttonClass = self.getAttribute('class'),

        div = self.parentNode.parentNode,

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
        all_sum = parseInt(span_all_sum.innerText);


    if ( 'add' == buttonClass ) {
        url = 'ajax/ajax_work_basket.php?action=basket_add&data=' + div_id;
        ++quantity;
        sum = price * quantity;
        ++all_count;
        all_sum += price;
    }
    else if ( 'del' == buttonClass ) {
        url = 'ajax/ajax_work_basket.php?action=basket_del&data=' + div_id;
        --quantity;
        sum = price * quantity;
        --all_count;
        all_sum -= price;
        if(0 === quantity) {
            div.innerHTML = '';
            div.style.display = 'none';
        }
    }


    request.open('GET', url, true);
    request.send(null);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            if(all_count == parseInt(request.responseText)) {
                div_quantity.innerHTML = quantity;
                div_sum.innerHTML = sum + ' кл';
                span_all_count.innerHTML = all_count;
                span_all_sum.innerHTML = all_sum;
            }

        }
    }

}
