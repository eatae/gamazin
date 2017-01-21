<?php
/*
 * блок подключается на главной странице.
 * описание сайта
 */
?>

<div id="description">

    <!-- Используемые технологии -->
    <div class="text_desc">
        <b>Используемые технологии:</b>

        <div class="text_item">
            - HTML, CSS<br>
            - JavaScript<br>
            - PHP<br>
            - MySQL<br>
            - AJAX<br>
        </div>
        <div class="text_item">
            Процедурный подход (исторически так сложилось).
        </div>
        <div class="text_item"><a href="https://github.com/eatae/gamazin">ссылка на GitHub</a></div>

    </div>
    <br>


    <!-- Концепция -->
    <div class="text_desc">
        <b>Концепция</b> - магазин товаров для детей.
    </div>
    <br>

    <div class="item3">
        Войти как <b>User</b>:
        <div class="text_item">
            user1 &nbsp; 11111
        </div>
    </div>

    <div class="item3">
        Войти как <b>User-Customer</b>:
        <div class="text_item">
            customer &nbsp; 22222
        </div>
    </div>

    <div class="item3">
        Войти как <b>Admin</b>:
        <div class="text_item">
            admin &nbsp; 00000<br>
        </div>
        <br>

        <div class="text_item">
            <b>&nbsp; - либо зарегестрируйтесь.</b>
        </div>
    </div>


    <!-- Функцилнал -->
    <div class="item1">
        Функционал:
        <!-- Регистрация -->
        <div class="item2">
            Регистрация:
            <div class="item3">
                - гость
                <div class="text_item">
                    - без регистрации.<br>
                    - может приобретать товар.<br>
                    - при покупке данные о нем сохраняются в базу.<br>
                </div>
            </div>

            <div class="item3">
                - пользователь
                <div class="text_item">
                    - должен быть зарегестрирован.<br>
                    - может оставлять отзывы.<br>
                    - данные о всех покупках сохраняются в базу (закреплены за учёткой).<br>
                </div>
            </div>

            <div class="item3">
                - админ
                <div class="text_item">
                    - может добавлять товар.<br>
                    - просматривать инфу по заказам.<br>
                    - просматривать инфу по покупателям.<br>
                    - поиск по базе.<br>
                </div>
            </div>

        </div>

        <!-- Корзина -->
        <div class="item2">
            Корзина:
            <div class="text_item">
                - калькулятор товаров.<br>
                - возможность увеличения / уменьшения кол-ва товаров.<br>
                - проверка контактных данных для зарегестрирванных польз.<br>
                - возможность изменения контактных данных для зарегестрированных польз.<br>
                - сохранение данных о покупателе.<br>
                - сохранение данных о заказе.<br>
                - отправка инф. о заказе на email покупателя.
            </div>
        </div>

        <!-- Админка -->
        <div class="item2">
            Админка
            <div class="text_item">
                ( вход: &nbsp; admin &nbsp; 00000 )<br>
                ссылка под меню слева
            </div>

            <div class="item3">
                - добавление товара
                <div class="text_item">
                    - добаление товара с загрузкой изображения.<br>
                </div>
            </div>

            <div class="item3">
                - заказы
                <div class="text_item">
                    - просмотр последних заказов.<br>
                    - переход по номеру заказа.<br>
                    - переход по email покупателя.<br>
                    - pagination.<br>
                    - return.<br>
                </div>
            </div>

            <div class="item3">
                - поиск
                <div class="text_item">
                    - покупателя по email.<br>
                    - заказ по номеру.<br>
                    - заказы по дате.<br>
                    - переход по ссылкам в таблицах.<br>
                    - pagination.<br>
                    - return.<br>
                </div>
            </div>

        </div>

        <!-- Отзывы -->
        <div class="item2">
            Отзывы
            <div class="text_item">
                - гостевая книга.
            </div>

        </div>

        <div id='carton2'></div>

    </div>
</div>