<?php
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? urldecode($_GET['action']) : '';
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';

switch($action){
	case '':
		// TODO Useless variable ?
		$priority = array(
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => 7,
			8 => 8,
			9 => 9
		);
		$nbPlugins = count($pluginsManager->getPlugins());
		break;
	case 'save':
		if($administrator->isAuthorized()){
			foreach($pluginsManager->getPlugins() as $k=>$v) {
				if(isset($_POST['activate'][$v->getName()])){
					if(!$v->isInstalled()) $pluginsManager->installPlugin($v->getName(), true);
					else $v->setConfigVal('activate', 1);
				}
				else $v->setConfigVal('activate', 0);
				if($v->isInstalled()){
					$v->setConfigVal('priority', intval($_POST['priority'][$v->getName()]));
					if(!$pluginsManager->savePluginConfig($v)){
						$msg = "Une erreur est survenue";
						$msgType = 'error';
					}
					else{
						$msg = "Modifications enregistrées";
						$msgType = 'success';
					}
				}
			}
		}
		header('location:index.php?p=pluginsmanager&msg='.urlencode($msg));
		die();
		break;
	case 'maintenance':
		if($administrator->isAuthorized()) $pluginsManager->installPlugin($_GET['plugin'], true);
		header('location:index.php?p=pluginsmanager');
		die();
		break;
}
?>
