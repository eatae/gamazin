/* this function call in ajaxLibrary.js - window.load  addEventListener */

var adm_press_button = function (self, buttons)
{
    var className;
    /* бежим по всем span'ам и стираем атрибут class */
    for (var cnt = 0; cnt < buttons.length; cnt++) {
        className = buttons[cnt].getAttribute('class');
        if ( 'adm_press_button' == className ) {
            buttons[cnt].setAttribute('class', '');
        }
    }
    /* а теперь устанавливаем класс нажатой кнопки */
    self.setAttribute('class', 'adm_press_button');
};
