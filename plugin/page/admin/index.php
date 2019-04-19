<?php
if(!defined('ROOT')) die();
$page = new page();
$mode = '';
$msg = '';
$msgType = '';
switch(ACTION){
	case 'save':
		if($_POST['id'] != '') $pageItem = $page->create($_POST['id']);
		else $pageItem = new pageItem();
		$pageItem->setName($_POST['name']);
		$pageItem->setUrl($_POST['url']);
		$pageItem->setIsHomepage((isset($_POST['isHomepage'])) ? 1 : 0);
		$pageItem->setPosition($_POST['position']);
		$pageItem->setContent($_POST['content']);
		$pageItem->setFile($_POST['file']);
		$pageItem->setIsHidden((isset($_POST['isHidden'])) ? 1 : 0);
		$pageItem->setMainTitle($_POST['mainTitle']);
		$pageItem->setMetaDescriptionTag($_POST['metaDescriptionTag']);
		$pageItem->setMetaTitleTag($_POST['metaTitleTag']);
		$page->save($pageItem);
		header('location:index.php?p=page');
		die();
		break;
	case 'edit':
		if(isset($_GET['id'])) $pageItem = $page->create($_GET['id']);
		else $pageItem = new pageItem();
		$mode = 'edit';
		break;
	case 'del':
		$pageItem = $page->create($_GET['id']);
		if($page->del($pageItem)){
			header('location:index.php?p=page');
			die();
		}
		else{
			$msg = "Suppression impossible";
			$msgType = 'error';
		}
	default:
		$pageItems = $page->getItems();
		$mode = 'list';
		if(!$page->createHomepage()){
			$msg = "Aucune page d'accueil n'est définie";
			$msgType = 'error';
		}
}
?>