<?php
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$error = false;
$rewriteBase = str_replace(array('index.php', 'install.php', 'admin/'), '', $_SERVER['PHP_SELF']);
$passwordError = false;

switch($action){
	case 'save':
		if($administrator->isAuthorized()){
			$config = array(
				'siteName' => (trim($_POST['siteName']) != '') ? trim($_POST['siteName']) : 'Démo',
				'adminEmail' => trim($_POST['adminEmail']),
				'siteUrl' => (trim($_POST['siteUrl']) != '') ? trim($_POST['siteUrl']) : $core->getConfigVal('siteUrl'),
				'theme' => $_POST['theme'],
				'defaultPlugin' => $_POST['defaultPlugin'],
				'urlRewriting' => (isset($_POST['urlRewriting'])) ? '1' : '0',
				'htaccessOptimization' => (isset($_POST['htaccessOptimization'])) ? '1' : '0',
				'siteLang' => $_POST['lang'],
				'hideTitles' => (isset($_POST['hideTitles'])) ? '1' : '0',
				'debug' => (isset($_POST['debug'])) ? '1' : '0',
				'defaultAdminPlugin' => $_POST['defaultAdminPlugin'],
				'urlSeparator' => $_POST['urlSeparator'],
			);
			if(trim($_POST['_adminPwd']) != ''){
				if(trim($_POST['_adminPwd']) == trim($_POST['_adminPwd2'])) $config['adminPwd'] = $administrator->encrypt(trim($_POST['_adminPwd']));
				else $passwordError = true;
			}
			if($passwordError){
				$msg = "Le mot de passe est différent de sa confirmation";
				$msgType = 'error';
			}
			elseif(!util::isEmail(trim($_POST['adminEmail']))){
				$msg = "Email invalide";
				$msgType = 'error';
			}
			elseif(!$core->saveConfig($config)){
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			else{
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			$core->saveHtaccess($_POST['htaccess']);
			header('location:index.php?p=configmanager&msg='.urlencode($msg));
			die();
		}
		break;
}
?>