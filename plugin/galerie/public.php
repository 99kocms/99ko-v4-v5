<?php
if(!defined('ROOT')) die();

$galerie = new galerie();
$runPlugin->setTitleTag($runPlugin->getConfigVal('label'));
if($runPlugin->getIsDefaultPlugin()){
    $runPlugin->setTitleTag($core->getConfigVal('siteName'));
    $runPlugin->setMetaDescriptionTag($core->getConfigVal('siteDescription'));
}
$runPlugin->setMainTitle($runPlugin->getConfigVal('label'));
?>