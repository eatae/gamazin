<?php
return function($data) {
    ?>
    <div id='helloUser'>Hello <?php echo $_SESSION['name']; ?> !</div>
    <!--  КНОПКА ВЫХОД  -->
    <form method='post' action='<?php echo $data[0] . "handlers_forms/exit.hf.php"; ?>'>
        <input type='hidden' name='dir' value='<?php echo $data['uri']; ?>'>
        <input type='image' id='exit' src='/img/marking/transparence.png'>
    </form>
    <?
};