<?php
if(!defined('ROOT')) die();

$msg = '';
$sendError = false;
$antispam = ($pluginsManager->isActivePlugin('antispam')) ? new antispam() : false;
if(isset($_GET['send'])){
	// quelques contrôle et temps mort volontaire avant le send...
	sleep(2);
	if($antispam){
		if(!$antispam->isValid()){
			$msg = "Antispam invalide";
			$sendError = true;
		}
	}
	if(!$sendError){
		if($_POST['_name'] == '' && strchr($_SERVER['HTTP_REFERER'], 'contact') && contactSend()) $msg = "Message envoyé.";
		else{
			$msg = "Champ(s) incomplet(s) ou email invalide";
			$sendError = true;
		}
	}
}
$name = ($sendError) ? $_POST['name'] : '';
$firstname = ($sendError) ? $_POST['firstname'] : '';
$email = ($sendError) ? $_POST['email'] : '';
$message = ($sendError) ? $_POST['message'] : '';
$acceptation = (trim($runPlugin->getConfigVal('acceptation')) != '') ? true : false;
$runPlugin->setMainTitle($runPlugin->getConfigVal('label'));
$runPlugin->setTitleTag($runPlugin->getConfigVal('label'));
$antispamField = ($antispam) ? $antispam->show() : '';
?>