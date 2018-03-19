<?php
defined('ROOT') OR exit('No pagesFileect script access allowed');

## Fonction d'installation

function contactInstall(){
	util::writeJsonFile(DATA_PLUGIN.'contact/emails.json', array());
}

## Hooks

## Code relatif au plugin

function contactSave($email){
	$data = util::readJsonFile(DATA_PLUGIN.'contact/emails.json');
	$data[] = $email;
	util::writeJsonFile(DATA_PLUGIN.'contact/emails.json', array_unique($data));
}

function contactSend(){
	global $runPlugin;
	$core = core::getInstance();
	$from = '99ko@'.$_SERVER['SERVER_NAME'];
	$reply = strip_tags(trim($_POST['email']));
	$name = strip_tags(trim($_POST['name']));
	$firstName = strip_tags(trim($_POST['firstname']));
	$msg = strip_tags(trim($_POST['message']));
	if(!util::isEmail($reply) || $name == '' || $firstName == '' || $msg == '') return false;
	contactSave($reply);
	$to = $core->getConfigVal('adminEmail');
	$subject = 'Contact '.$core->getConfigVal('siteName');
	$msg = $msg."\n\n----------\n\n".$name." ".$firstName." (".$reply.")";
	if(util::isEmail($runPlugin->getConfigVal('copy'))) util::sendEmail($from, $reply, $runPlugin->getConfigVal('copy'), $subject, $msg);
	return util::sendEmail($from, $reply, $to, $subject, $msg);
}
?>