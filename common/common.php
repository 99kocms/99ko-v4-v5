<?php
/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

session_start();
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'common/config.php');
include_once(COMMON.'util.class.php');
include_once(COMMON.'core.class.php');
include_once(COMMON.'pluginsManager.class.php');
include_once(COMMON.'plugin.class.php');
include_once(COMMON.'show.class.php');
$core = core::getInstance();
if(!$core->isInstalled()){
	header('location:' .ROOT. 'install.php');
	die();
}
$pluginsManager = pluginsManager::getInstance();
foreach($pluginsManager->getPlugins() as $plugin){
	include_once($plugin->getLibFile());
	if($plugin->getConfigVal('activate')){
		foreach($plugin->getHooks() as $name=>$function){
			$core->addHook($name, $function);
		}
	}
}
## $runPLugin représente le plugin en cours d'execution et s'utilise avec la classe plugin & pluginsManager
$runPlugin = $pluginsManager->getPlugin($core->getPluginToCall());
