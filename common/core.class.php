<?php
/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Maxence Cauderlier (mx.koder@gmail.com)
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

defined('ROOT') OR exit('No direct script access allowed');

class core{
    private static $instance = null;
    private $config;
    private $hooks;
    private $themes;
    private $pluginToCall;
    private $js;
    private $css;
    
    ## Constructeur
    public function __construct(){
        // Timezone
        date_default_timezone_set(date_default_timezone_get());
        // Construction du tableau de configuration
        // Exemple : array('siteName' => 'val', 'siteUrl' => 'val2')
        $this->config = util::readJsonFile(DATA.'config.json', true);
        // Réglage de l'error reporting suivant le paramètre debug
        if ($this->config && $this->config['debug']){
            ini_set('display_errors', 1); 
            error_reporting(E_ALL);
        }
        else error_reporting(E_ERROR | E_PARSE);
        // Liste des thèmes
        $temp = util::scanDir(THEMES);
        foreach($temp['dir'] as $k=>$v){
            $this->themes[$v] = util::readJsonFile(THEMES.$v.'/infos.json', true);
        }
        // On détermine le plugin que l'on doit executer suivant le mode (public ou admin)
        if(ROOT == './') $this->pluginToCall = isset($_GET['p']) ? $_GET['p'] : $this->getConfigVal('defaultPlugin');
        else $this->pluginToCall = isset($_GET['p']) ? $_GET['p'] : $this->getConfigVal('defaultAdminPlugin');
        // Ressources JS & CSS de base
        $this->css[] = NORMALIZE;
        $this->js[] = JQUERY;
    }
    
    ## Retourne l'instance de l'objet core
    public static function getInstance(){
        if(is_null(self::$instance)) self::$instance = new core();
        return self::$instance;
    }
    
    ## Retourne la liste des thèmes
    public function getThemes(){
        return $this->themes;
    }
    
    ## Retourne la configuration complète
    public function getconfig(){
        return $this->config;
    }
    
    ## Retourne une valeur de configuration
    public function getConfigVal($k){
        if(isset($this->config[$k])) return $this->config[$k];
        else return false;
    }
    
    ## Retourne les infos du thème ciblé
    public function getThemeInfo($k){
        if(isset($this->themes[$this->getConfigVal('theme')])) return $this->themes[$this->getConfigVal('theme')][$k];
        else return false;
    }
    
    ## Retourne l'identifiant du plugin solicité
    public function getPluginToCall(){
        return $this->pluginToCall;
    }
    
    ## Retourne le tableau de ressources JS de base
    public function getJs(){
        return $this->js;
    }
    
    ## Retourne le tableau de ressources CSS de base
    public function getCss(){
        return $this->css;
    }
    
    ## Détermine si 99ko est installé
    public function isInstalled(){
        if(!file_exists(DATA.'config.json')) return false;
        else return true;
    }
    
    ## Génère l'URL du site
    public function makeSiteUrl(){
        $siteUrl = str_replace(array('install.php', '/admin/index.php'), array('', ''), $_SERVER['SCRIPT_NAME']);
        $isSecure = false;
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $isSecure = true;
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') $isSecure = true;
        $REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';
        $siteUrl = $REQUEST_PROTOCOL.'://'.$_SERVER['HTTP_HOST'].$siteUrl;
        $pos = mb_strlen($siteUrl)-1;
        if($siteUrl[$pos] == '/') $siteUrl = substr($siteUrl, 0, -1);
        return $siteUrl;
    }
    
    ## Alimente le tableau des hooks
    public function addHook($name, $function){
        $this->hooks[$name][] = $function;
    }
    
    /**
     * Permet d'appeler un hook
     * Si un paramètre est fourni, celui-ci sera passé de fonction en fonction Hook de filtre).
     * Sinon, la valeur de retour sera concaténé à chaque fonction (Hook d'action).
     * 
     * @param   string  Nom du hook
     * @param   mixed   Paramètres
     * @return  mixed
     */
    public function callHook($name, $params = null) {
        if ($params === null) {
            // Action
            $return = '';
            if (isset($this->hooks[$name])) {
                foreach ($this->hooks[$name] as $function) {
                    $return .= call_user_func($function);
                }
            }
            return $return;
        }
        // Filter
        if (isset($this->hooks[$name])) {
            foreach ($this->hooks[$name] as $function) {
                $params = call_user_func($function, $params);
            }
        }
        return $params;
    }
    
    ## Detecte le mode de l'administration
    public function detectAdminMode(){
        $mode = '';
        if(isset($_GET['action']) && $_GET['action'] == 'login') return 'login';
        elseif(isset($_GET['action']) && $_GET['action'] == 'logout') return 'logout';
        elseif(isset($_GET['action']) && $_GET['action'] == 'lostpwd') return 'lostpwd';
        elseif(!isset($_GET['p'])) return 'plugin';
        elseif(isset($_GET['p'])) return 'plugin';
    }
    
    ## Renvoi une page 404
    public function error404($mainTitle = '404'){
            $core = $this;
            global $runPlugin;
            if($runPlugin) $runPlugin->setMainTitle('Error 404 :(');
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            include_once(THEMES.$this->getConfigVal('theme').'/header.php');	
            include_once(THEMES.$this->getConfigVal('theme').'/404.php');
            include_once(THEMES.$this->getConfigVal('theme').'/footer.php');
            die();
    }
    
    ## Update le fichier de configuration
    public function saveConfig($val, $append = array()){
        $config = util::readJsonFile(DATA.'config.json', true);
        $config = array_merge($config, $append);
        foreach($config as $k=>$v) if(isset($val[$k])){
            $config[$k] = $val[$k];
        }
        if(util::writeJsonFile(DATA.'config.json', $config)){
            $this->config = util::readJsonFile(DATA.'config.json', true);
            return true;
        }
        else return false;
    }
    
    ## Installation de 99ko
    public function install(){
        $install = true;
        @chmod(ROOT.'.htaccess', 0604);
        if(!file_exists(ROOT.'.htaccess')){
            $rewriteBase = str_replace(array('index.php', 'install.php', 'admin/'), '', $_SERVER['PHP_SELF']);
            $temp = "Options -Indexes\nOptions +FollowSymlinks\nRewriteEngine On\nRewriteBase ".$rewriteBase."\nRewriteRule ^admin/$  admin/ [L]\nRewriteRule ^([a-z-0-9_]+)/$  index.php?p=$1 [L]\nErrorDocument 404 /index.php?p=404";
            if(!@file_put_contents(ROOT.'.htaccess', $temp, 0604)) $install = false;
        }
        if(!is_dir(DATA) && (!@mkdir(DATA) || !@chmod(DATA, 0644))) $install = false;
        if($install){
            if(!file_exists(DATA. '.htaccess')){
                if(!@file_put_contents(DATA. '.htaccess', "deny from all", 0604)) $install = false;
            }
            if(!is_dir(DATA_PLUGIN) && (!@mkdir(DATA_PLUGIN) || !@chmod(DATA_PLUGIN, 0644))) $install = false;
            if(!is_dir(UPLOAD) && (!@mkdir(UPLOAD) || !@chmod(UPLOAD, 0644))) $install = false;
            if(!file_exists(UPLOAD. '.htaccess')){
                if(!@file_put_contents(UPLOAD. '.htaccess', "allow from all", 0604)) $install = false;
            }
            if(!file_exists(__FILE__) || !@chmod(__FILE__, 0644)) $install = false;
            $key = uniqid(true);
            if(!file_exists(DATA. 'key.php') && !@file_put_contents(DATA. 'key.php', "<?php define('KEY', '$key'); ?>", 0644)) $install = false;
        }
        return $install;
    }
    
    ## Retourne le contenu du fichier htaccess
    
    public function getHtaccess(){
        return @file_get_contents(ROOT.'.htaccess');
    }
    
    ## Update le contenu du fichier htaccess
    
    public function saveHtaccess($content){
        $content = str_replace("&amp;", "&", $content);
        @file_put_contents(ROOT.'.htaccess', $content);
    }
}
?>