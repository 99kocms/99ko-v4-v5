<?php
/*
 * 99ko CMS (since 2010)
 * http://janisjoplin.fr/page/made-with-99ko-cms,28.html
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

defined('ROOT') OR exit('No direct script access allowed');

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
	private $publicFile;
	private $adminFile;
	private $paramTemplate;
	private $dataPath;
	private $publicTemplate;
	private $adminTemplate;
	private $initConfig;
	private $navigation;
	private $publicCssFile;
	private $publicJsFile;
	private $adminCssFile;
	private $adminJsFile;
	private $isDefaultAdminPlugin;
	
	## Constructeur
	public function __construct($name, $config = array(), $infos = array(), $hooks = array(), $initConfig = array()){
		$core = core::getInstance();
		// Identifiant du plugin
		$this->name = $name;
		// Tableau de configuration
		$this->config = $config;
		// Tableau d'informations
		$this->infos = $infos;
		// Liste des hooks
		$this->hooks = $hooks;
		// Validité du plugin
		$this->isValid = true;
		// On détermine si il s'agit du plugin par défaut en mode public
		$this->isDefaultPlugin = ($name == $core->getConfigVal('defaultPlugin')) ? true : false;
		// On détermine si il s'agit du plugin par défaut en mode admin
		$this->isDefaultAdminPlugin = ($name == $core->getConfigVal('defaultAdminPlugin')) ? true : false;
		// Meta title
		$this->setTitleTag($infos['name']);
		// Titre de page
		$this->setMainTitle($infos['name']);
		// Fichier php principal
		$this->libFile = (file_exists(PLUGINS .$this->name.'/'.$this->name.'.php')) ? PLUGINS .$this->name.'/'.$this->name.'.php' : false;
		// Controlleur en mode public
		$this->publicFile = (file_exists(PLUGINS .$this->name.'/public.php')) ? PLUGINS .$this->name.'/public.php' : false;
		// Controlleur en mode admin
		$this->adminFile = (file_exists(PLUGINS .$this->name.'/admin.php')) ? PLUGINS .$this->name.'/admin.php' : false;
		// CSS
		$this->publicCssFile = (file_exists(PLUGINS .$this->name.'/template/public.css')) ? PLUGINS .$this->name.'/template/public.css' : false;
		$this->adminCssFile = (file_exists(PLUGINS .$this->name.'/template/admin.css')) ? PLUGINS .$this->name.'/template/admin.css' : false;
		// JS
		$this->publicJsFile = (file_exists(PLUGINS .$this->name.'/template/public.js')) ? PLUGINS .$this->name.'/template/public.js' : false;
		$this->adminJsFile = (file_exists(PLUGINS .$this->name.'/template/admin.js')) ? PLUGINS .$this->name.'/template/admin.js' : false;
		// Répertoir de sauvegarde des données internes du plugin
		$this->dataPath = (is_dir(DATA_PLUGIN .$this->name)) ? DATA_PLUGIN .$this->name.'/' : false;
		// Template public (peut etre le template par defaut ou un template présent dans le dossier du theme portant le nom du plugin)
		if(file_exists('theme/'.$core->getConfigVal('theme').'/'.$this->name.'.php')) $this->publicTemplate = 'theme/'.$core->getConfigVal('theme').'/'.$this->name.'.php';
		elseif(file_exists(PLUGINS .$this->name.'/template/public.php')) $this->publicTemplate = PLUGINS .$this->name.'/template/public.php';
		else $this->publicTemplate = false;
		// Template admin
		$this->adminTemplate = (file_exists(PLUGINS.$this->name.'/template/admin.php')) ? PLUGINS.$this->name.'/template/admin.php' : false;
		// Template parametres
		$this->paramTemplate = (file_exists(PLUGINS.$this->name.'/template/param.php')) ? PLUGINS.$this->name.'/template/param.php' : false;
		// Configuration d'usine
		$this->initConfig = $initConfig;
		// Navigation
		$this->navigation = array();
	}
	
	## Getters
	public function getConfigVal($val){
		if(isset($this->config[$val])) return $this->config[$val];
	}
	
	public function getConfig(){
		return $this->config;
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
	
	public function getMetaDescriptionTag(){
		return $this->metaDescriptionTag;
	}
	
	public function getMainTitle(){
		return $this->mainTitle;
	}
	
	public function getLibFile(){
		return $this->libFile;
	}
	
	public function getPublicFile(){
		return $this->publicFile;
	}
	
	public function getAdminFile(){
		return $this->adminFile;
	}
	
	public function getPublicCssFile(){
		return $this->publicCssFile;
	}
	
	public function getAdminCssFile(){
		return $this->adminCssFile;
	}
	
	public function getPublicJsFile(){
		return $this->publicJsFile;
	}
	
	public function getAdminJsFile(){
		return $this->adminJsFile;
	}
	
	public function getDataPath(){
		return $this->dataPath;
	}
	
	public function getPublicTemplate(){
		return $this->publicTemplate;
	}
	
	public function getAdminTemplate(){
		return $this->adminTemplate;
	}
	
	public function getParamTemplate(){
		return $this->paramTemplate;
	}
	
	public function getConfigTemplate(){
		return $this->configTemplate;
	}
	
	public function getIsValid(){
		return $this->isValid;
	}
	
	public function getNavigation(){
		return $this->navigation;
	}
	
	public function getIsDefaultAdminPlugin(){
		return $this->isDefaultAdminPlugin;
	}

	## Permet de modifier une valeur de configuration
	public function setConfigVal($k, $v){
		$this->config[$k] = $v;
		if($k == 'activate' && $v < 1 && $this->isRequired()) $this->isValid = false;
	}
	
	## Permet de forcer la meta title
	public function setTitleTag($val){
		$this->titleTag = trim($val);
	}
	
	## Permet de forcer la meta description
	public function setMetaDescriptionTag($val){
		$this->metaDescriptionTag = trim($val);
	}
	
	## Permet de forcer le titre de page
	public function setMainTitle($val){
		$this->mainTitle = trim($val);
	}
	
	## Ajoute un item dans la navigation
	function addToNavigation($label, $target, $targetAttribut = '_self', $id = 0, $parent = 0, $cssClass = ''){
		$this->navigation[] = array('label' => $label, 'target' => $target, 'targetAttribut' => $targetAttribut, 'id' => $id, 'parent' => $parent, 'cssClass' => $cssClass);
	}
	
	## Supprime un item de la navigation
	function removeToNavigation($k){
		unset($this->navigation[$k]);
	}

	## Initialise la navigation
	function initNavigation(){
		$this->navigation = array();
	}

	## Détermine si le plugin est installé
	public function isInstalled(){
		$temp = $this->config;
		unset($temp['activate']);
		$currentConfig = implode(',', array_keys($temp));
		$initConfig = @implode(',', array_keys($this->initConfig));
		if(count($this->config) < 1 || $currentConfig != $initConfig) return false;
		return true;
	}
	
	## Détermine si le plugin est protégé, ce qui empèche de le désactiver
	public function isRequired(){
		if(isset($this->config['protected']) && $this->config['protected'] == 1) return true;
		if($this->isDefaultPlugin) return true;
		return false;
	}
}
?>