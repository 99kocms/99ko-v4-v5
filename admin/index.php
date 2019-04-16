<?php
// on declare ROOT
define('ROOT', '../');
// on inclu le fichier common
include_once(ROOT.'common/common.php');
// on genere le jeton
if(!isset($_SESSION['token'])) $_SESSION['token'] = uniqid();
// on check le jeton
if(in_array(ACTION, array('save', 'del', 'saveconfig', 'saveplugins', 'login', 'logout')) && $_REQUEST['token'] != $_SESSION['token']){	
	die();
}
// variables de template
$data['msg'] = '';
$data['msgConfig'] = '';
$data['msgPlugins'] = '';
$data['99koVersion'] = VERSION;
$data['linkTags'][] = ROOT.'common/normalize.css';
$data['linkTags'][] = 'styles.css';
$data['scriptTags'] = array();
$data['pluginName'] = $runPlugin->getInfoVal('name');
$data['configSiteName'] = $coreConf['siteName'];
$data['configSiteUrl'] = $coreConf['siteUrl'];
$data['configAdminEmail'] = $coreConf['adminEmail'];
$data['configThemes'] = array();
$data['plugins'] = array();
$data['openTab'] = (isset($_GET['opentab'])) ? ucfirst($_GET['opentab']) : '';
$data['mainTabTitle'] = (isset($_GET['p'])) ? $runPlugin->getInfoVal('name') : 'Informations';
$data['token'] = $_SESSION['token'];
foreach($plugins as $plugin) if($plugin->getConfigVal('activate')){
	if($plugin->getCssFile()) $data['linkTags'][] = $plugin->getCssFile();
	if($plugin->getJsFile()) $data['scriptTags'][] = $plugin->getJsFile();
}
$data['linkTags'] = array_unique($data['linkTags']);
$data['scriptTags'] = array_unique($data['scriptTags']);
foreach($plugins as $k=>$plugin){
	$data['plugins'][$k]['id'] = $plugin->getName();
	$data['plugins'][$k]['isDefaultPlugin'] = $plugin->getIsDefaultPlugin();
	$data['plugins'][$k]['name'] = $plugin->getInfoVal('name');
	$data['plugins'][$k]['description'] = $plugin->getInfoVal('description');
	$data['plugins'][$k]['target'] = ($plugin->getAdminFile()) ? 'index.php?p='.$plugin->getName() : false;
	$data['plugins'][$k]['activate'] = ($plugin->getConfigVal('activate')) ? true : false;
	$data['plugins'][$k]['priority'] = $plugin->getConfigVal('priority');
	$data['plugins'][$k]['version'] = $plugin->getInfoVal('version');
	$data['plugins'][$k]['author'] = $plugin->getInfoVal('author');
	$data['plugins'][$k]['authorEmail'] = $plugin->getInfoVal('authorEmail');
	$data['plugins'][$k]['authorWebsite'] = $plugin->getInfoVal('authorWebsite');
	$data['plugins'][$k]['frontFile'] = $plugin->getFrontFile();
}
foreach(listThemes() as $k=>$theme){
	$data['configThemes'][$k]['name'] = $theme;
	$data['configThemes'][$k]['selected'] = ($theme == getConfVal('core', 'theme')) ? true : false;
}
// check secu
$data['msgSecurity'] = '';
if($coreConf['adminPwd'] == 'cbdbe4936ce8be63184d9f2e13fc249234371b9a') $data['msgSecurity'] = "Le mot de passe admin doit être modifié !\n";
if(!file_exists('../.htaccess')) $data['msgSecurity'].= "Le fichier .htaccess est manquant !\n";
if(file_exists('../install.php')) $data['msgSecurity'].= "Le fichier install.php doit être supprimé !\n";
// actions
switch(ACTION){
	// identification
	case 'login':
		$loginAttempt = (isset($_SESSION['loginAttempt'])) ? $_SESSION['loginAttempt'] : 0;
		$loginAttempt++;
		$_SESSION['loginAttempt'] = $loginAttempt;
		if($loginAttempt > 4 || !isset($_SESSION['loginAttempt'])){
			$data['msg'] = "Veuillez attendre avant de faire une nouvelle tentative";
		}
		else{
			$pwd = $coreConf['adminPwd'];
			if(sha1(trim($_POST['adminPwd'])) == $pwd){
				$_SESSION['admin'] = $pwd;
				$_SESSION['loginAttempt'] = 0;
				$_SESSION['token'] = uniqid();
				header('location:index.php');
				die();
			}
			else $data['msg'] = "Mot de passe incorrect";
		}
		break;
	// logout
	case 'logout':
		unset($_SESSION['admin']);
		unset($_SESSION['loginAttempt']);
		unset($_SESSION['token']);
		header('location:index.php');
		die();
		break;
	// sauvegarde de la configuration du core
	case 'saveconfig':
		$error = false;
		$config = array(
			'siteName' => (trim($_POST['siteName']) != '') ? trim($_POST['siteName']) : 'Démo',
			'adminEmail' => (utilIsEmail(trim($_POST['adminEmail']))) ? trim($_POST['adminEmail']) : 'you@domain.com',
			'siteUrl' => (trim($_POST['siteUrl']) != '') ? trim($_POST['siteUrl']) : getSiteUrl(),
			'theme' => $_POST['theme'],
			'defaultPlugin' => $_POST['defaultPlugin'],
		);
		if(trim($_POST['adminPwd']) != ''){
			if($_POST['adminPwd'] == $_POST['adminPwd2']) $config['adminPwd'] = sha1(trim($_POST['adminPwd']));
			else{
				$data['msgConfig'] = "Mot de passe différent de sa confirmation";
				$error = true;
			}
		}
		if(!saveConfig($config)){
			$data['msgConfig'] = "Erreur d'enregistrement de la configuration";
			$error = true;
		}
		if(trim($_POST['adminPwd']) != '' && $_POST['adminPwd'] == $_POST['adminPwd2']) $_SESSION['admin'] = $config['adminPwd'];
		if(!$error){
			header('location:index.php?opentab=config');
			die();
		}
		break;
	// sauvegarde des plugins
	case 'saveplugins':
		$error = false;
		foreach($plugins as $k=>$plug){
			if(isset($_POST['activate'][$plug->getName()])) $plug->setConfigVal('activate', 1);
			else $plug->setConfigVal('activate', 0);
			$plug->setConfigVal('priority', intval($_POST['priority'][$plug->getName()]));
			if(!plugin::saveConfig($plug)){
				$error = true;
				$data['msgPlugins'] = "Erreur d'enregistrement de la configuration du plugin";
			}
		}
		if(!$error){
			header('location:index.php?opentab=plugins');
			die();
		}
		break;
}
// si on est pas identifie on impose le login
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $coreConf['adminPwd']){
	include_once('login.php');
}
else{
	// on inclu le fichier admin du plugin courant
	if(isset($_GET['p']) && $runPlugin->getAdminFile()) include($runPlugin->getAdminFile());
	else include_once('home.php');
}
?>
