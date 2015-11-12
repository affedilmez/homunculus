<?php
$hom = Homunculus::getInstance();

switch ($hom->getFragmentKey()):
case 'first':
?>
<p>When stored in the fragments.php file can be easily retrieved by multiple pages.</p>
<?php
break;

case 'second':
?>
<p>Fragments can be used for content regions that would be unwieldy as variable contents.</p>
<?php
break;

endswitch;
