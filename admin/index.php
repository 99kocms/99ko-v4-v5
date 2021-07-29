<?php
/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

define('ROOT', '../');
include_once(ROOT.'common/common.php');
include_once(COMMON.'administrator.class.php');
$administrator = new administrator($core->getConfigVal('adminEmail'), $core->getConfigVal('adminPwd'));
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
if($administrator->isAuthorized() && $core->detectAdminMode() == 'login'){
	// quelques contrôle et temps mort volontaire avant le login...
	sleep(2);
	if($_POST['_email'] == ''){
		// authentification
		if($administrator->login($_POST['adminEmail'], $_POST['adminPwd'])){
			header('location:index.php');
			die();
		}
		else{
			$msg = "Mot de passe incorrect";
			include_once('login.php');
		}
	}
}
elseif($administrator->isAuthorized() && $core->detectAdminMode() == 'logout'){
	$administrator->logout();
	header('location:index.php');
	die();
}
elseif($administrator->isAuthorized() && $core->detectAdminMode() == 'lostpwd'){
	$step = (isset($_GET['step']) ? $_GET['step'] : 'form');
	if($step == 'send' && $administrator->isAuthorized() && $administrator->getEmail() == $_POST['adminEmail']){
		// quelques contrôle et temps mort volontaire avant le login...
		sleep(2);
		$administrator->makePwd();
	}
	elseif($step == 'confirm' && $administrator->isAuthorized()){
		// quelques contrôle et temps mort volontaire avant le login...
		sleep(2);
		$config = $core->getConfig();
		$config['adminPwd'] = $administrator->encrypt($administrator->getNewPwd());
		$core->saveConfig($config);
	}
	include_once('lostpwd.php');
}
if(!$administrator->isLogged() && $core->detectAdminMode() != 'lostpwd') include_once('login.php');
elseif($core->detectAdminMode() == 'plugin'){
	include($runPlugin->getAdminFile());
	if(!is_array($runPlugin->getAdminTemplate())) include($runPlugin->getAdminTemplate());
}
?>