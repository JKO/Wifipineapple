<?php
namespace pineapple;

$pineapple = new Pineapple(__FILE__);

$pineapple->drawTabs(
    [
    'main.php'=>'Main',
    'about.php'=>'About'
    ]
);

?>
<script type='text/javascript' src='<?=$rel_dir?>js/helpers.js'></script>
