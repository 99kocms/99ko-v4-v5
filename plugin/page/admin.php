<?php
defined('ROOT') OR exit('No direct script access allowed');

$mode = '';
$action = (isset($_GET['action'])) ? urldecode($_GET['action']) : '';
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$error = false;
$page = new page();

switch($action){
	case 'save':
		if($administrator->isAuthorized()){
			$imgId = '';
			if($pluginsManager->isActivePlugin('galerie')){
				$galerie = new galerie();
				$img = ($_REQUEST['imgId']) ? $galerie->createItem($_REQUEST['imgId']) : new galerieItem();
				if($img){
					$img->setCategory('');
					$img->setTitle($_POST['name'].' (image à la une)');
					$img->setContent('');
					$img->setDate(date('Y-m-d H:i:s'));
					$img->setHidden(1);
					$galerie->saveItem($img);
					$imgId = $galerie->getLastId();
				}
			}
			if($_POST['id'] != '') $pageItem = $page->create($_POST['id']);
			else $pageItem = new pageItem();
			$pageItem->setName($_POST['name']);
			$pageItem->setPosition($_POST['position']);
			$pageItem->setIsHomepage((isset($_POST['isHomepage'])) ? 1 : 0);
			$pageItem->setContent((isset($_POST['content'])) ? $_POST['content'] : '');
			$pageItem->setFile((isset($_POST['file'])) ? $_POST['file'] : '');
			$pageItem->setIsHidden((isset($_POST['isHidden'])) ? 1 : 0);
			$pageItem->setMainTitle((isset($_POST['mainTitle'])) ? $_POST['mainTitle'] : '');
			$pageItem->setMetaDescriptionTag((isset($_POST['metaDescriptionTag'])) ? $_POST['metaDescriptionTag'] : '');
			$pageItem->setMetaTitleTag((isset($_POST['metaTitleTag'])) ? $_POST['metaTitleTag'] : '');
			$pageItem->setTarget((isset($_POST['target'])) ? $_POST['target'] : '');
			$pageItem->setTargetAttr((isset($_POST['targetAttr'])) ? $_POST['targetAttr'] : '');
			$pageItem->setNoIndex((isset($_POST['noIndex'])) ? 1 : 0);
			$pageItem->setParent((isset($_POST['parent'])) ? $_POST['parent'] : '');
			$pageItem->setCssClass($_POST['cssClass']);
			$pageItem->setImg($imgId);
			if(isset($_POST['_password']) && $_POST['_password'] != '') $pageItem->setPassword($_POST['_password']);
			if(isset($_POST['resetPassword'])) $pageItem->setPassword('');
			if($page->save($pageItem)) $msg = "Les modifications ont été enregistrées";
			else $msg = "Une erreur est survenue";
			header('location:index.php?p=page&msg='.urlencode($msg));
			die();
		}
		break;
	case 'edit':
			if(isset($_GET['id'])) $pageItem = $page->create($_GET['id']);
			else $pageItem = new pageItem();
			$isLink = (isset($_GET['link']) || $pageItem->targetIs() == 'url') ? true : false;
			$isParent = (isset($_GET['parent']) || $pageItem->targetIs() == 'parent') ? true : false;
			$mode = 'edit';
		break;
	case 'del':
		if($administrator->isAuthorized()){
			$pageItem = $page->create($_GET['id']);
			if($page->del($pageItem)) $msg = "Les modifications ont été enregistrées";
			else $msg = "Une erreur est survenue";
			header('location:index.php?p=page&msg='.urlencode($msg));
			die();
		}
		break;
	case 'up':
		if($administrator->isAuthorized()){
			$pageItem = $page->create($_GET['id']);
			$newPos = $pageItem->getPosition()-1.5;
			$pageItem->setPosition($newPos);
			$page->save($pageItem);
			header('location:index.php?p=page');
			die();
		}
		break;
	case 'down':
		if($administrator->isAuthorized()){
			$pageItem = $page->create($_GET['id']);
			$newPos = $pageItem->getPosition()+1.5;
			$pageItem->setPosition($newPos);
			$page->save($pageItem);
			header('location:index.php?p=page');
			die();
		}
		break;
	case 'maintenance':
		$id = explode(',', $_GET['id']);
		foreach($id as $k=>$v) if($v != ''){
			$pageItem = $page->create($v);
			$page->del($pageItem);
		}
		header('location:index.php?p=page');
		die();
		break;
	default:
		// Recherche des pages perdues
		$parents = array();
		$lost = '';
		foreach($page->getItems() as $k=>$v) if($v->getParent() == 0){
			$parents[] = $v->getId();
		}
		foreach($page->getItems() as $k=>$v) if($v->getParent() > 0){
			if(!in_array($v->getParent(), $parents)) $lost.= $v->getId().',';
		}
		// Suite...
		if(!$page->createHomepage()) $msg = "Aucune page d'accueil définie";
		$mode = 'list';
}
?>