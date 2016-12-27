
/* this function call in ajax.lib.js - window.load  addEventListener */

var adm_press_button = function(self, adminMenuSpan)
{
    var className;
    /* бежим по span'ам меню и стираем атрибут class */
    for ( var cnt=0; cnt < adminMenuSpan.length; cnt++ ) {
        className = adminMenuSpan[cnt].getAttribute('class');
        if ( 'adm_press_button' == className ) {
            adminMenuSpan[cnt].setAttribute('class', '');
        }
    }
    /* в self приходит this - устанавливаем класс нажатой кнопки */
    self.setAttribute('class', 'adm_press_button');
};
