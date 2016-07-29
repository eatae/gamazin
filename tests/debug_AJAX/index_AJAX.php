<?php
require_once('../../inc/gamaz_lib.inc.php');
require_once('../../inc/data_for_page.inc.php');

$title = 'Магазин-Гамазин';


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
    <script src='../../js/leftMenu.js'></script>

    <!-- AJAX -->
    <script type='text/javascript' src='xmlHttpRequest.js'></script>
    <script type='text/javascript'>
        var contentBlock,
            request = getXMLHttpRequest();

        window.onload = function(){
            contentBlock = document.getElementById('content');
            console.log(contentBlock);
        };


//***** encodeURIComponent for IE ******//
        function get_Products(title){
            var url = 'ajax_select_products.php?title_name='+encodeURIComponent(title);
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


////////////////////////////////////////




    function do_html_main(){
    global $menu;
    $menu = getProducts();// look header
    ?>

        <!--MAIN-->
        <div id='main'>
            <div id='center'>

                <!--LEFT MENU-->
                <div id='borderleftmenu'>
                    <div id='leftmenu'>


                        <div id='up_leftmenu'>
                            <a id='basket' href='#'>Корзина: 0</a>
                        </div>

                        <ul>
                            <?
                            foreach($menu as $nameCategory => $arrayCategory){
                                ?>
                                <li class='outmenu'>
                                    <p class='out'><?=$nameCategory?></p>
                                    <div class='submenu'>
                                        <div class='bla'>
                                            <ul>
                                                <?
                                                foreach($arrayCategory as $titleName=>$titleVal){
                                                    ?>
                                                    <li onclick="showProducts(this)" ><?=$titleName?></li>
                                                    <?
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <?
                            }
                            ?>
                        </ul>

                        <div id='bottom_leftmenu'>
                        </div>


                    </div>
                </div>
                <!--END LEFT MENU-->


                <!--CONTENT-->
                <div id='wrapContent'>
                    <div id='content'>  </div>
                    <!--картонка-->
                    <div id='carton1'></div>
                    <!--картонка-->
                <!--<div id='carton2'></div>-->
            </div>
        </div>
    </div>
    <?
    //menu();
    //for showItems.js
    if($_GET['basket']){
        echo '<script>showItems('.'\''.$_GET['tit'].'\''.','.'\'id_'.$_GET['basket'].'\''.');</script>';
    }
    }/*end function*/



/////////////////////////////////




function do_html_footer(){
?>
    <!--FOOTER-->
    <div id='footer'>
        <!--			<div id='bg_foot_left'></div>-->
        <!--			<div id='bg_foot_right'></div>-->
        <div id='footmenu'>
            <a href="mailto:al-loco@mail.ru">al-loco@mail.ru</a>
            <ul>
                <li><a href="#">Контакты</a></li>
                <li><a href="#">Отзывы</a></li>
                <li><a href="#">Почемучто</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
<?php
}/*end function*/


do_html_header($title);
do_html_main();
do_html_footer();


?>