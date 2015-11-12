<?php

require_once dirname(dirname(__FILE__)).'/Homunculus.php';

$hom = Homunculus::getInstance('theme');
$hom->store(array('title' => 'Homunculus Demo'));

$hom->top();

?>
<p>Example page using Homunculus class.
    The same header/footer can be used across <a href="another_page.php">multiple pages</a>.</p>
<?php
$hom->retrieveFragment('second');
$hom->retrieveFragment('first');

$hom->bottom();
?>
