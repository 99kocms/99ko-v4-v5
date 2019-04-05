<?php
defined('ROOT') OR exit('No direct script access allowed');
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
switch($action){
	case 'save':
		if($administrator->isAuthorized()){
            $runPlugin->setConfigVal('trackingId', trim($_POST['trackingId']));
			$runPlugin->setConfigVal('wt', trim($_POST['wt']));
			$runPlugin->setConfigVal('facebook', trim($_POST['facebook']));
			$runPlugin->setConfigVal('twitter', trim($_POST['twitter']));
			$runPlugin->setConfigVal('youtube', trim($_POST['youtube']));
            if($pluginsManager->savePluginConfig($runPlugin)){
                $msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
            }
            else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=seo&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	default:
}
?>