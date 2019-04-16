<?php
if(!defined('ROOT')) die();

###### Fonctions nécessaires

/*
** Fonction chargée de retourner la configuration par defaut du plugin (obligatoire)
*/

function pageConfig(){
	return array(
		'priority' => 2,
		'activate' => 1,
	);
}

/*
** Fonction chargée de retourner les infos du plugin (obligatoire)
*/

function pageInfos(){
	return array(
		'name' => 'Page',
		'description' => 'Permet la création de pages statiques',
		'author' => 'Jonathan Coulet',
		'authorEmail' => 'j.coulet@gmail.com',
		'authorWebsite' => 'http://99ko.tuxfamily.org',
		'version' => '1.4',
	);
}

/*
** Fonction chargée de retourner les hooks utilises par le plugin (obligatoire)
*/

function pageHooks(){
	return array(
		'startFrontIncludePluginFile' => 'pageHook1',
	);	
}

/*
** Fonction chargée de l'installation interne du plugin (facultatif)
*/

function pageInstall(){
	// Création des règles de réécriture d'URL
	$htaccess = @file_get_contents(ROOT.'.htaccess');
	$htaccess.= "\nRewriteRule ^page/([a-zA-Z0-9-_]+)-([a-zA-Z0-9-_]+).html$  index.php?p=page&url=$1&id=$2 [L]";
	@file_put_contents(ROOT.'.htaccess', $htaccess, 0666);
	// Création de la première page
	$page = new page();
	if(count($page->getItems()) < 1){
		$pageItem = new pageItem();
		$pageItem->setName('Page 1');
		$pageItem->setPosition(1);
		$pageItem->setIsHomepage(1);
		$pageItem->setContent('<p>Atque, ut Tullius ait, ut etiam ferae fame monitae plerumque ad eum locum ubi aliquando pastae sunt revertuntur, ita homines instar turbinis degressi montibus impeditis et arduis loca petivere mari confinia, per quae viis latebrosis sese convallibusque occultantes cum appeterent noctes luna etiam tum cornuta ideoque nondum solido splendore fulgente nauticos observabant quos cum in somnum sentirent effusos per ancoralia, quadrupedo gradu repentes seseque suspensis passibus iniectantes in scaphas eisdem sensim nihil opinantibus adsistebant et incendente aviditate saevitiam ne cedentium quidem ulli parcendo obtruncatis omnibus merces opimas velut viles nullis repugnantibus avertebant. haecque non diu sunt perpetrata.</p>');
		$pageItem->setIsHidden(0);
		$pageItem->setFile('');
		$page->save($pageItem);
	}
}

###### Code interne du plugin

/*
** Configuration
*/

define('PAGE_DATAPATH', ROOT.'data/plugin/page/');

/*
** Hooks
*/

function pageHook1(){
	global $coreConf, $runPlugin;
	function pageMainNavigation($siteUrl, $defaultPlugin){
		$page = new page();
		$data = '';
		foreach($page->getItems() as $k=>$pageItem) if(!$pageItem->getIsHidden()){
			$target = ($defaultPlugin == 'page' && $pageItem->getIsHomepage()) ? $siteUrl : 'page/'.utilStrToUrl($pageItem->getName()).'-'.$pageItem->getId().'.html';
			// fix bug (MaxguN)
			$data.= "\$data['mainNavigation'][".$pageItem->getPosition()."]['target'] = '".$target."';";
			$data.= "\$data['mainNavigation'][".$pageItem->getPosition()."]['label'] = '".$pageItem->getName()."';";
		}
		return $data;
	}
	return pageMainNavigation($coreConf['siteUrl'], $coreConf['defaultPlugin']);
}

/*
** Classe
*/

class page{
	private $items;
	
	public function __construct(){
		$data = array();
		if(is_dir(PAGE_DATAPATH)){
			$dataNotSorted = array();
			$items = utilScanDir(PAGE_DATAPATH, array('config.txt'));
			foreach($items['file'] as $k=>$file){
				$temp = json_decode(@file_get_contents(ROOT.'data/plugin/page/'.$file), true);
				$dataNotSorted[] = $temp;
			}
			$dataSorted = utilSort2DimArray($dataNotSorted, 'position', 'num');
			foreach($dataSorted as $pageItem){
				$data[] = new pageItem($pageItem);
			}
		}
		$this->items = $data;
	}
	
	public function getItems(){
		return $this->items;
	}
	
	public function create($id){
		foreach($this->items as $pageItem){
			if($pageItem->getId() == $id) return $pageItem;
		}
		return false;
	}
	
	public function createHomepage(){
		foreach($this->items as $pageItem){
			if($pageItem->getIshomepage()) return $pageItem;
		}
		return false;
	}
	
	public function save($obj){
		$id = intval($obj->getId());
		if($id < 1) $id = $this->makeId();
		$data = array(
			'id' => $id,
			'name' => $obj->getName(),
			'position' => $obj->getPosition(),
			'isHomepage' => $obj->getIsHomepage(),
			'content' => $obj->getContent(),
			'isHidden' => $obj->getIsHidden(),
			'file' => $obj->getFile(),
			'mainTitle' => $obj->getMainTitle(),
			'metaDescriptionTag' => $obj->getMetaDescriptionTag(),
			'metaTitleTag' => $obj->getMetaTitleTag(),
		);
		if($obj->getIsHomepage() > 0) $this->initIshomepageVal();
		if(@file_put_contents(PAGE_DATAPATH.$id.'.txt', json_encode($data), 0666)){
			$this->repairPositions($obj);
			return true;
		}
		return false;
	}
	
	public function del($obj){
		if($obj->getIsHomepage() < 1 && $this->count() > 1){
			if(@unlink(PAGE_DATAPATH.$obj->getId().'.txt')) return true;
		}
		return false;
	}
	
	public function count(){
		return count($this->items);
	}
	
	public function listFiles(){
		$data = array();
		$items = utilScanDir(ROOT.'theme/'.getConfVal('core', 'theme').'/', array('header.php', 'footer.php', 'style.css'));
		foreach($items['file'] as $file){
			if(in_array(utilGetFileExtension($file), array('htm', 'html', 'txt', 'php'))) $data[] = $file;
		}
		return $data;
	}
	
	private function makeId(){
		$ids = array(0);
		foreach($this->items as $pageItem){
			$ids[] = $pageItem->getId();
		}
		return max($ids)+1;
	}

	private function initIshomepageVal(){
		foreach($this->items as $obj){
			$obj->setIsHomepage(0);
			$this->save($obj);
		}
	}
	
	private function repairPositions($currentObj){
		foreach($this->items as $obj) if($obj->getId() != $currentObj->getId()){
			$pos = $obj->getPosition();
			if($pos == $currentObj->getPosition()){
				$obj->setPosition($pos+1);
				$this->save($obj);
			}
		}
	}
}

class pageItem{
	private $id;
	private $name;
	private $position;
	private $isHomepage;
	private $content;
	private $isHidden;
	private $file;
	private $mainTitle;
	private $metaDescriptionTag;
	private $metaTitleTag;
	
	public function __construct($val = array()){
		if(count($val) > 0){
			$this->id = $val['id'];
			$this->name = $val['name'];
			$this->position = $val['position'];
			$this->isHomepage = $val['isHomepage'];
			$this->content = $val['content'];
			$this->isHidden = $val['isHidden'];
			$this->file = $val['file'];
			$this->mainTitle = $val['mainTitle'];
			$this->metaDescriptionTag = $val['metaDescriptionTag'];
			$this->metaTitleTag = $val['metaTitleTag'];
		}
	}

	public function setName($val){
		$val = trim($val);
		if($val == '') $val = "Page sans nom";
		$this->name = $val;
	}
	
	public function setPosition($val){
		$this->position = intval($val);
	}
	
	public function setIsHomepage($val){
		$this->isHomepage = trim($val);
	}
	
	public function setContent($val){
		$this->content = trim($val);
	}
	
	public function setIsHidden($val){
		$this->isHidden = intval($val);
	}
	
	public function setFile($val){
		$this->file = trim($val);
	}
	
	public function setMainTitle($val){
		$this->mainTitle = trim($val);
	}
	
	public function setMetaDescriptionTag($val){
		$this->metaDescriptionTag = trim($val);
	}
	
	public function setMetaTitleTag($val){
		$this->metaTitleTag = trim($val);
	}

	public function getId(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getPosition(){
		return $this->position;
	}
	
	public function getIsHomepage(){
		return $this->isHomepage;
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function getIsHidden(){
		return $this->isHidden;
	}
	
	public function getFile(){
		return $this->file;
	}
	
	public function getMainTitle(){
		return $this->mainTitle;
	}
	
	public function getMetaDescriptionTag(){
		return $this->metaDescriptionTag;
	}
	
	public function getMetaTitleTag(){
		return $this->metaTitleTag;
	}
}
?>