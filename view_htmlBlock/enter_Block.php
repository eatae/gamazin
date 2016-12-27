<?php
return function($data) {
    ?>
    <form method='post' action='<?php echo $data[0] . 'handlers_forms/enter.hf.php'; ?>'>
        <input type='hidden' name='dir' value='<?php echo $data['uri']; ?>'>
        <input type='text' class='pl' name='login'>
        <input type='password' class='pl' name='pass'>
        <input type='image' src='/img/marking/transparence.png'>
    </form>
    <?php
};