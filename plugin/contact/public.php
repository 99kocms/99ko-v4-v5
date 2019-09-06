<?php
if(!defined('ROOT')) die();

$msg = '';
$sendError = false;
if($core->getUrlParam(0) == 'send'){
	// quelques contrôle et temps mort volontaire avant le send...
	sleep(2);
	if($_POST['_name'] == '' && $_SERVER['HTTP_REFERER'] == $core->getConfigVal('siteUrl').'/'.$core->makeUrl('contact') && contactSend()) $msg = "Message envoyé.";
	else{
		$msg = "Champ(s) incomplet(s) ou email invalide";
		$sendError = true;
	}
}
$name = ($sendError) ? $_POST['name'] : '';
$firstname = ($sendError) ? $_POST['firstname'] : '';
$email = ($sendError) ? $_POST['email'] : '';
$message = ($sendError) ? $_POST['message'] : '';
$acceptation = (trim($runPlugin->getConfigVal('acceptation')) != '') ? true : false;
$runPlugin->setMainTitle($runPlugin->getConfigVal('label'));
$runPlugin->setTitleTag($runPlugin->getConfigVal('label'));
?>