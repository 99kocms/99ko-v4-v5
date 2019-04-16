<?php
if(!defined('ROOT')) die();
ini_set('display_errors', 1); 
error_reporting(E_ALL);
session_start();
// on check le fichier de configuration
if(!file_exists(ROOT.'data/config.txt')){
	header('location:'.ROOT.'install.php');
	die();
}
// constantes
define('VERSION', '1.1.1');
define('ACTION', ((isset($_GET['action'])) ? $_GET['action'] : ''));
// tableau des hooks
$hooks = array();
// on inclu les librairies
include_once(ROOT.'common/core.lib.php');
// on charge la config du core
$coreConf = getCoreConf();
//constantes
define('DEFAULT_PLUGIN', $coreConf['defaultPlugin']);
define('PLUGIN', ((isset($_GET['p'])) ? $_GET['p'] : DEFAULT_PLUGIN)); // voir $runPlugin
// on boucle les plugins pour charger les lib et les installer
foreach(plugin::listAll() as $plugin){
	// on inclu la librairie
	include_once($plugin->getLibFile());
	// si le plugin n'est pas installé on l'installe
	if(!$plugin->isInstalled()) plugin::install($plugin->getName());
}
// on charge les plugins
$plugins = plugin::listAll();
// on boucle les plugins actifs pour le traitement des hooks
foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
	// on update le tableau des hooks
	foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
}
// on cree l'instance du plugin solicite
$runPlugin = plugin::create(PLUGIN);
// si le plugin solicite est inactif on stop
if($runPlugin->getConfigVal('activate') < 1) die();
?>
