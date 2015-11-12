<?php

require_once 'Homunculus.php';

$hom = Homunculus::getInstance('demo');
$hom->store(array('title' => 'Homunculus Demo'));

$hom->top();

?>
<p>Example page using Homunculus framework</p>
<?php
$hom->retrieveFragment('second');
$hom->retrieveFragment('first');

$hom->bottom();
?>
