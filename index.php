<?php
$time = microtime(true);
// on declare ROOT
define('ROOT', './');
// on inclu le fichier common
include_once(ROOT.'common/common.php');
// variables de template
$data['99koVersion'] = VERSION;
$data['titleTag'] = '';
$data['siteDescription'] = $coreConf['siteDescription'];
$data['metaDescriptionTag'] = '';
$data['linkTags'][] = ROOT.'common/normalize.css';
$data['scriptTags'] = array();
$data['siteName'] = $coreConf['siteName'];
$data['siteUrl'] = $coreConf['siteUrl'];
$data['mainTitle'] = '';
$data['mainNavigation'] = array();
$data['theme'] = $coreConf['theme'];
foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
	if($plugin->getCssFile()) $data['linkTags'][] = $plugin->getCssFile();
	if($plugin->getJsFile()) $data['scriptTags'][] = $plugin->getJsFile();
}
$data['linkTags'][] = ROOT.'theme/'.getConfVal('core', 'theme').'/styles.css';
// hook
eval(callHook('startFrontIncludePluginFile'));
// on inclu le fichier front du plugin courant
if($runPlugin->getFrontFile()) include($runPlugin->getFrontFile());
// hook
eval(callHook('endFrontIncludePluginFile'));
?>
