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
	eval(callHook('startShowMsg'));
	if($msg != '') $data = '<div id="msg" class="'.$class[$type].'"><p>'.nl2br($msg).'</p></div>';
	eval(callHook('endShowMsg'));
	echo $data;
}

/*
** Affiche les balises links
** @param : $format (format)
*/
function showLinkTags($format = '<link href="[file]" rel="stylesheet" type="text/css" />'){
	global $data;
	foreach($data['linkTags'] as $file){
		echo str_replace('[file]', $file, $format);
	}
}

/*
** Affiche les balises script
** @param : $format (format)
*/
function showScriptTags($format = '<script type="text/javascript" src="[file]"></script>'){
	global $data;
	foreach($data['scriptTags'] as $file){
		echo str_replace('[file]', $file, $format);
	}
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
	eval(callHook('startShowAdminEditor'));
	$data = '<textarea style="width:'.$width.'px;height:'.$height.'px" name="'.$name.'" id="'.$id.'" class="'.$class.'">'.$content.'</textarea>';
	eval(callHook('endShowAdminEditor'));
	echo $data;
}

/*
** Affiche un input hidden contenant le token en session (admin)
** @return : string HTML
*/
function showAdminTokenField(){
	global $data;
	eval(callHook('startShowAdminTokenField'));
	$output = '<input type="hidden" name="token" value="'.$data['token'].'" />';
	eval(callHook('endShowAdminTokenField'));
	echo $output;
}

/*
** Fonctions d'affichage front
*/

/*
** Affiche le contenu de la meta title
*/
function showTitleTag(){
	global $data, $runPlugin;
	echo (($data['titleTag'] == '') ? $runPlugin->getTitleTag() : $data['titleTag']);
}

/*
** Affiche le contenu de la meta description
*/
function showMetaDescriptionTag(){
	global $data, $runPlugin;
	echo (($data['metaDescriptionTag'] == '') ? $runPlugin->getMetaDescriptionTag() : $data['metaDescriptionTag']);
}

/*
** Affiche le titre H1
*/
function showMainTitle(){
	global $data, $runPlugin;
	echo (($data['mainTitle'] == '') ? $runPlugin->getMainTitle() : $data['mainTitle']);
}

/*
** Affiche le nom du site
*/
function showSiteName(){
	global $data;
	echo $data['siteName'];
}

/*
** Affiche la description du site
*/
function showSiteDescription(){
	global $data;
	echo $data['siteDescription'];
}

/*
** Affiche l'url du site
*/
function showSiteUrl(){
	global $data;
	echo $data['siteUrl'];
}

/*
** Affiche le temps de génération
*/
function showExecTime(){
	global $time;
	echo round(microtime(true) - $time, 3);
}

/*
** Affiche le menu principal
** @param : $format (format)
*/
function showMainNavigation($format = '<li><a href="[target]">[label]</a></li>'){
	global $data;
	foreach($data['mainNavigation'] as $item){
		$output = $format;
		$output = str_replace('[target]', $item['target'], $output);
		$output = str_replace('[label]', $item['label'], $output);
		echo $output;
	}
}

/*
** Affiche le fil d'Ariane
*/
function showBreadcrumb(){
	global $runPlugin, $data;
	if(count($runPlugin->getBreadcrumb()) > 0){
		echo '<p id="breadcrumb"><a href="'.$data['siteUrl'].'">Accueil</a>';
		foreach($runPlugin->getBreadcrumb() as $item){
			echo ' >> <a href="'.$item['target'].'">'.$item['label'].'</a>';
		}
		echo '</p>';
	}
}
?>
