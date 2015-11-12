<?php

require_once dirname(dirname(__FILE__)).'/Homunculus.php';

$hom = Homunculus::getInstance('theme');
$hom->store(array('title' => 'Another Homunculus Page'));

$hom->top();

?>
<p>Another page using the Homunculus class.</p>
<?php $hom->retrieveFragment('second'); ?>
<p><a href="index.php">Return to first page.</a></p>
<?php $hom->bottom(); ?>
