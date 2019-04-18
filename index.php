<?php
// on declare ROOT
define('ROOT', './');
// on inclu le fichier common
include_once(ROOT.'common/common.php');
// on inclu le fichier front du plugin courant
if($runPlugin->getFrontFile()) include($runPlugin->getFrontFile());
?>
