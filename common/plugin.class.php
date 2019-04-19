<?php

/*
** Classe responsable des plugins
*/

class plugin{
	private $infos;
	private $config;
	private $name;
	private $hooks;
	private $isValid;
	private $isDefaultPlugin;
	private $titleTag;
	private $metaDescriptionTag;
	private $mainTitle;
	private $libFile;
	private $frontFile;
	private $adminFile;
	private $frontTemplate;
	private $adminTemplate;
	private $cssFile;
	private $jsFile;
	private $dataPath;
	private $menuItems;

	public function __construct($name, $config = array(), $infos = array(), $hooks = array(), $menuItems = array()){
		$this->name = $name;
		$this->config = $config;
		$this->infos = $infos;
		$this->hooks = $hooks;
		$this->isValid = true;
		$this->isDefaultPlugin = ($name == DEFAULT_PLUGIN) ? true : false;
		$this->setTitleTag($infos['name']);
		$this->setMainTitle($infos['name']);
		$this->libFile = (file_exists(ROOT.'plugin/'.$this->name.'/index.php')) ? ROOT.'plugin/'.$this->name.'/index.php' : false;
		$this->frontFile = (file_exists(ROOT.'plugin/'.$this->name.'/public/index.php')) ? ROOT.'plugin/'.$this->name.'/public/index.php' : false;
		$this->adminFile = (file_exists(ROOT.'plugin/'.$this->name.'/admin/index.php')) ? ROOT.'plugin/'.$this->name.'/admin/index.php' : false;
		$this->frontTemplate = (file_exists(ROOT.'plugin/'.$this->name.'/public/template.php')) ? ROOT.'plugin/'.$this->name.'/public/template.php' : false;
		$this->adminTemplate = (file_exists(ROOT.'plugin/'.$this->name.'/admin/template.php')) ? ROOT.'plugin/'.$this->name.'/admin/template.php' : false;
		$this->cssFile = (file_exists(ROOT.'plugin/'.$this->name.'/'.$this->name.'.css')) ? ROOT.'plugin/'.$this->name.'/'.$this->name.'.css' : false;
		$this->jsFile = (file_exists(ROOT.'plugin/'.$this->name.'/'.$this->name.'.js')) ? ROOT.'plugin/'.$this->name.'/'.$this->name.'.js' : false;
		$this->dataPath = (is_dir(ROOT.'data/plugin/'.$this->name)) ? ROOT.'data/plugin/'.$this->name.'/' : false;
		$this->menuItems = $menuItems;
	}

	/*
	** getters
	*/
	
	public function getConfigVal($val){
		return $this->config[$val];
	}
	
	public function getInfoVal($val){
		return $this->infos[$val];
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getHooks(){
		return $this->hooks;
	}
	
	public function getIsDefaultPlugin(){
		return $this->isDefaultPlugin;
	}
	
	public function getTitleTag(){
		return $this->titleTag;
	}
	
	public function getMetaTitleTag(){
		return $this->metaTitleTag;
	}
	
	public function getMetaDescriptionTag(){
		return $this->metaDescriptionTag;
	}
	
	public function getMainTitle(){
		return $this->mainTitle;
	}
	
	public function getLibFile(){
		return $this->libFile;
	}
	
	public function getFrontFile(){
		return $this->frontFile;
	}
	
	public function getAdminFile(){
		return $this->adminFile;
	}
	
	public function getFrontTemplate(){
		return $this->frontTemplate;
	}
	
	public function getAdminTemplate(){
		return $this->adminTemplate;
	}
	
	public function getCssFile(){
		return $this->cssFile;
	}
	
	public function getJsFile(){
		return $this->jsFile;
	}
	
	public function getDataPath(){
		return $this->dataPath;
	}
	
	public function getMenuItems(){
		return $this->menuItems;
	}

	/*
	** setters
	*/
	
	public function setConfigVal($k, $v){
		$this->config[$k] = $v;
		if($k == 'activate' && $v < 1 && $this->isDefaultPlugin) $this->isValid = false;
	}
	
	public function setTitleTag($val){
		$val = $val.' | '.getConfVal('core', 'siteName');
		if(mb_strlen($val) > 50) $val = mb_strcut($val, 0, 50).'...';
		$this->titleTag = $val;
	}
	
	public function setMetatitleTag($val){
		$this->metaTitleTag = trim($val);
	}
	
	public function setMetaDescriptionTag($val){
		$this->metaDescriptionTag = trim($val);
	}
	
	public function setMainTitle($val){
		$val = trim($val);
		$this->mainTitle = $val;
	}

	/*
	** Détermine si le plugin est installé / updaté
	** @return : true / false
	*/
	
	public function isInstalled(){
		// on check si la config existe
		if(count($this->config) < 1) return false;
		// on compare la config initiale avec la config actuelle
		$currentConfig = implode(',', array_keys($this->config));
		$initialConfig = implode(',', array_keys(call_user_func($this->name.'Config')));
		if($currentConfig != $initialConfig) return false;
		return true;
	}

	/*
	** liste les plugins
	** @return : array
	*/
	
	public static function listAll(){
		$data = array();
		$dataNotSorted = array();
		$items = utilScanDir(ROOT.'plugin/');
		foreach($items['dir'] as $dir){
			$dataNotSorted[$dir] = json_decode(@file_get_contents(ROOT.'data/plugin/'.$dir.'/config.txt'), true);
		}
		$dataSorted = utilSort2DimArray($dataNotSorted, 'priority', 'num');
		foreach($dataSorted as $plugin=>$config){
			$data[] = plugin::create($plugin);
		}
		return $data;
	}
	
	/*
	** liste les plugins actifs
	** @return : array
	*/
	
	public static function listActive(){
		$data = plugin::listAll();
		foreach($data as $k=>$plugin){
			if($plugin->getConfigVal('activate') < 1) unset($data[$k]);
		}
		return $data;
	}
	
	/*
	** Crée un objet plugin
	** @return : objet plugin
	*/
	
	public static function create($name){
		$config = array();
		if(file_exists(ROOT.'data/plugin/'.$name.'/config.txt')) $config = json_decode(@file_get_contents(ROOT.'data/plugin/'.$name.'/config.txt'), true);
		$infos = @call_user_func($name.'Infos');
		$hooks = @call_user_func($name.'Hooks');
		$menuItems = @call_user_func($name.'MenuItems');
		return new plugin($name, $config, $infos, $hooks, $menuItems);
	}
	
	/*
	** Installe / update un plugin
	** @param : $name (nom du plugin)
	** @return : true / false
	*/
	
	public static function install($name){
		@mkdir(ROOT.'data/plugin/'.$name.'/', 0777);
		@chmod(ROOT.'data/plugin/'.$name.'/', 0777);
		@file_put_contents(ROOT.'data/plugin/'.$name.'/config.txt', json_encode(call_user_func($name.'Config')), 0666);
		@chmod(ROOT.'data/plugin/'.$name.'/config.txt', 0666);
		if(function_exists($name.'Install')) call_user_func($name.'Install');
		if(!file_exists(ROOT.'data/plugin/'.$name.'/config.txt')) return false;
		return true;
	}
	
	/*
	** Enregistre la config d'un plugin
	** @param : $obj (objet plugin)
	** @return : true / false
	*/
	
	public static function saveConfig($obj){
		if($obj->isValid && $path = $obj->getDataPath()){
			if(@file_put_contents($path.'config.txt', json_encode($obj->config), 0666)) return true;
		}
		return false;
	}
	
	/*
	** Détermine si un plugin est installé et actif
	** @param : $name (nom du plugin)
	** @return : true / false
	*/
	
	public static function isActive($name){
		$plugin = plugin::create($name);
		if($plugin->isInstalled() && $plugin->getConfigval('activate')) return true;
		return false;
	}
}
?>