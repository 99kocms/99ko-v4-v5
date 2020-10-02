<?php
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$galerie = new galerie();

switch($action){
	case 'saveconf':
		if($administrator->isAuthorized()){
            $runPlugin->setConfigVal('label', trim($_POST['label']));
            $runPlugin->setConfigVal('order', trim($_POST['order']));
			$runPlugin->setConfigVal('introduction', trim($_POST['introduction']));
			$runPlugin->setConfigVal('showTitles', trim($_POST['showTitles']));
			$runPlugin->setConfigVal('size', trim($_POST['size']));
            if($pluginsManager->savePluginConfig($runPlugin)){
                $msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
            }
            else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=galerie&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'save':
		if($administrator->isAuthorized()){
			$item = ($_REQUEST['id']) ?  $galerie->createItem($_REQUEST['id']) : new galerieItem();
			$item->setCategory($_REQUEST['category']);
			$item->setTitle($_REQUEST['title']);
			$item->setContent($_REQUEST['content']);
			$item->setDate($_REQUEST['date']);
			$item->setHidden((isset($_POST['hidden'])) ? 1 : 0);
			if($galerie->saveItem($item)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=galerie&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'del':
		if($administrator->isAuthorized()){
			$item = $galerie->createItem($_REQUEST['id']);
			if($galerie->delItem($item)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=galerie&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'edit':
		$mode = 'edit';
		$item = (isset($_REQUEST['id'])) ?  $galerie->createItem($_GET['id']) : new galerieItem();
		if($item->getDate() == '') $item->setDate('');
		break;
	default:
		$mode = 'list';
}
