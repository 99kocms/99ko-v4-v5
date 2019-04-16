<?php
if(!defined('ROOT')) die();
include_once('util.lib.php');
include_once('plugin.class.php');
include_once('show.lib.php');

/*
** Fonctions internes
*/

/*
** Renvoie une valeur de configuration du core ou d'un plugin
** @param : $plugin (nom du plugin), $kConf (clé de configuration)
** @return : string (valeur) / false
*/
function getConfVal($plugin, $kConf){
	global $coreConf;
	// si on demande une valeur config du core on tente de recuperer la valeur dans $coreConf
	if($plugin == 'core' && isset($coreConf[$kConf])) return $coreConf[$kConf];
	// sinon on lit le fichier config du core ou du plugin solicite
	if($plugin == 'core') $file = ROOT.'data/config.txt';
	else $file = ROOT.'data/plugin/'.$plugin.'/config.txt';
	$config = json_decode(@file_get_contents($file), true);
	foreach($config as $k=>$v){
		if($k == $kConf) return $v;
	}
	return false;
}

/*
** Renvoie la configuration du core
** @return : array
*/
function getCoreConf(){
	return json_decode(@file_get_contents(ROOT.'data/config.txt'), true);
}

/*
** Enregistre la configuration du core
** @param : $val (valeur a updater), $append (tableau de nouvelles valeurs)
*/
function saveConfig($val, $append = array()){
	$config = json_decode(@file_get_contents(ROOT.'data/config.txt'), true);
	$config = array_merge($config, $append);
	foreach($config as $k=>$v){
		if(isset($val[$k])) $config[$k] = $val[$k];
	}
	if(@file_put_contents(ROOT.'data/config.txt', json_encode($config), 0666)) return true;
	return false;
}

/*
** Appelle un hook
** @param : $hook
** @return : string (PHP)
*/
function callHook($hookName){
	global $hooks;
	$return = '';
	if(isset($hooks[$hookName])) foreach($hooks[$hookName] as $function){
		$return.= call_user_func($function);
	}
	return $return;
}

/*
** Ajoute un hook
** @param : $hookName (nom du hook), $function (fonction a executer)
*/
function addHook($hookName, $function){
	global $hooks;
	$hooks[$hookName][] = $function;
}

/*
** liste le dossier theme
** @return : array
*/
function listThemes(){
	$data = array();
	$items = utilScanDir(ROOT.'theme/');
	foreach($items['dir'] as $file){
		$data[] = $file;
	}
	return $data;
}
/*
** Détecte l'url de base
** @return : string (URL de base)
*/
function getSiteUrl(){
	$siteUrl = str_replace(array('install.php', '/admin/index.php'), array('', ''), $_SERVER['SCRIPT_NAME']);
	$siteUrl = 'http://'.$_SERVER['HTTP_HOST'].$siteUrl;
	$pos = mb_strlen($siteUrl)-1;
	if($siteUrl[$pos] == '/') $siteUrl = substr($siteUrl, 0, -1);
	return $siteUrl;
}
?>
