<!DOCTYPE html>
<?php $hom = Homunculus::getInstance(); ?>
<html>
<head>
<title><?php $hom->retrieve('title'); ?></title>
<?php
$hom->htmlInclude('css');
$hom->htmlInclude('headJS');
