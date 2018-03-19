<?php
if(!defined('ROOT')) die();

$action = (!is_numeric($core->getUrlParam(0))) ? $core->getUrlParam(0) : '';
$newsManager = new newsManager();

switch($action){
	case '':
		// Mode d'affichage
		$mode = 'list';
		// Détermination de la page courante
		if($core->getUrlParam(0) == '') $currentPage = 1;
		else $currentPage = $core->getUrlParam(0);
		// Contruction de la pagination
		$nbNews = count($newsManager->getItems()); 
		$newsByPage = $runPlugin->getConfigVal('itemsByPage');
		$nbPages = ceil($nbNews/$newsByPage);
		$start = ($currentPage-1)*$newsByPage+1;
		$end = $start+$newsByPage-1;
		$pagination = array();
		for($i=0;$i!=$nbPages;$i++){
			if($i != 0) $pagination[$i]['url'] = $core->makeUrl('news', array('page' => $i+1));
			else $pagination[$i]['url'] = $core->makeUrl('news');
			$pagination[$i]['num'] = $i+1;
		}
		// Récupération des news
		$news = array();
		$i = 1;
		foreach($newsManager->getItems() as $k=>$v) if(!$v->getDraft()){
			$date = $v->getDate();
			if($i >= $start && $i <= $end){
				$news[$k]['name'] = $v->getName();
				$news[$k]['date'] = util::FormatDate($date, 'en', 'fr');
				$news[$k]['id'] = $v->getId();
				$news[$k]['content'] = $v->getContent();
				$news[$k]['url'] = $core->makeUrl('news', array('action' => 'read', 'name' => util::strToUrl($v->getName()), 'id' => $v->getId()));
			}
			$i++;
		}
		// Traitements divers : métas, fil d'ariane...
		$runPlugin->setMainTitle($pluginsManager->getPlugin('news')->getConfigVal('label'));
		$runPlugin->setTitleTag($pluginsManager->getPlugin('news')->getConfigVal('label').' : page '.$currentPage);
		if($runPlugin->getIsDefaultPlugin() && $currentPage == 1){
			$runPlugin->setTitleTag($pluginsManager->getPlugin('news')->getConfigVal('label'));
			$runPlugin->setMetaDescriptionTag($core->getConfigVal('siteDescription'));
		}
		break;
	case 'read':
		// Mode d'affichage
		$mode = 'read';
		// Récupération de la news
		$item = $newsManager->create($core->getUrlParam(2));
		if(!$item) $core->error404();
		$newsManager->loadComments($item->getId());
		// Traitements divers : métas, fil d'ariane...
		$runPlugin->setMainTitle($item->getName());
		$runPlugin->setTitleTag($item->getName());
		break;
	case 'rss':
		echo $newsManager->rss();
		break;
	case 'send':
		// quelques contrôle et temps mort volontaire avant le send...
		sleep(2);
		if($runPlugin->getConfigVal('comments') && $_POST['_author'] == ''){
			$comments = $newsManager->loadComments($_POST['id']);
			$comment = new newsComment();
			$comment->setIdNews($_POST['id']);
			$comment->setAuthor($_POST['author']);
			$comment->setAuthorEmail($_POST['authorEmail']);
			$comment->setDate('');
			$comment->setContent($_POST['content']);
			if($newsManager->saveComment($comment)){
				header('location:'.$_POST['back'].'#comment'.$comment->getId());
				die();
			}
		}
		break;
	default:
		$core->error404();
}
?>