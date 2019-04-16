<?php
// on declare ROOT
define('ROOT', './');
// on inclu le fichier common
include_once(ROOT.'common/common.php');
// variables de template ... doit disparaitre....
$data['mainNavigation'] = array();
// hook
eval(callHook('startFrontIncludePluginFile')); // doit disparaitre....
// on inclu le fichier front du plugin courant
if($runPlugin->getFrontFile()) include($runPlugin->getFrontFile());
?>
