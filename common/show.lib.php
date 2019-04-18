<?php

/*
** Fonctions d'affichage admin & front
*/

/*
** Affiche un message (error/success) système
** @param : $msg (message), $type (error/success)
** @return : string HTML
*/

function showMsg($msg, $type){
	$class = array(
		'error' => 'error',
		'success' => 'success',
	);
	$data = '';
	if($msg != '') $data = '<div id="msg" class="'.$class[$type].'"><p>'.nl2br($msg).'</p></div>';
	echo $data;
}

/*
** Affiche les balises links
** @param : $format (format)
*/

function showLinkTags($format = '<link href="[file]" rel="stylesheet" type="text/css" />'){
	global $plugins;
	foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
		if($plugin->getCssFile()){
			echo str_replace('[file]', $plugin->getCssFile(), $format);
		}
	}
	if(ROOT == './') echo str_replace('[file]', ROOT.'theme/'.getConfVal('core', 'theme').'/styles.css', $format);
	elseif(ROOT == '../') echo str_replace('[file]', ROOT.'admin/styles.css', $format);
}

/*
** Affiche les balises script
** @param : $format (format)
*/

function showScriptTags($format = '<script type="text/javascript" src="[file]"></script>'){
	global $plugins;
	foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
		if($plugin->getJsFile()){
			echo str_replace('[file]', $plugin->getJsFile(), $format);
		}
	}
	if(ROOT == './') echo str_replace('[file]', ROOT.'theme/'.getConfVal('core', 'theme').'/scripts.js', $format);
	elseif(ROOT == '../') echo str_replace('[file]', ROOT.'admin/scripts.js', $format);
}

/*
** Fonctions d'affichage admin
*/

/*
** Affiche l'editeur HTML
** @param : $name (attribut name), $content, $width, $height, $id (attribut id), $class (attribut class)
** @return : string HTML
*/

function showAdminEditor($name, $content, $width, $height, $id = 'editor', $class = 'editor'){
	$data = '<textarea style="width:'.$width.'px;height:'.$height.'px" name="'.$name.'" id="'.$id.'" class="'.$class.'">'.$content.'</textarea>';
	echo $data;
}

/*
** Affiche un input hidden contenant le token en session (admin)
** @return : string HTML
*/

function showAdminTokenField(){
	global $data;
	$output = '<input type="hidden" name="token" value="'.$data['token'].'" />';
	echo $output;
}

/*
** Fonctions d'affichage front
*/

/*
** Affiche le contenu de la meta title
*/

function showMetaTitleTag(){
	global $runPlugin;
	echo $runPlugin->getMetaTitleTag();
}

/*
** Affiche le contenu de la meta description
*/

function showMetaDescriptionTag(){
	global $data, $runPlugin;
	echo $runPlugin->getMetaDescriptionTag();
}

/*
** Affiche le titre H1
*/

function showMainTitle(){
	global $runPlugin;
	echo $runPlugin->getMainTitle();
}

/*
** Affiche le nom du site
*/

function showSiteName(){
	global $coreConf;
	echo $coreConf['siteName'];
}

/*
** Affiche l'url du site
*/

function showSiteUrl(){
	global $coreConf;
	echo $coreConf['siteUrl'];
}

/*
** Affiche le menu principal
** @param : $format (format)
*/

function showMainNavigation($format = '<li><a href="[target]">[label]</a></li>'){
	global $plugins;
	foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
		foreach($plugin->getMenuItems() as $menuItem){
			$output = $format;
			$output = str_replace('[target]', $menuItem[1], $output);
			$output = str_replace('[label]', $menuItem[0], $output);
			echo $output;
		}
	}
}
?>