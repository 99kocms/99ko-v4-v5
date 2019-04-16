<?php
define('ROOT', './');
include_once(ROOT.'common/core.lib.php');
if(utilPhpVersion() < '5.1.2') die("Vous devez disposer d'un serveur équipé de PHP 5.1.2 ou plus !");
setMagicQuotesOff();
$error = false;
define('DEFAULT_PLUGIN', 'page');
if(isset($_GET['updateto'])){
	$coreConf = getCoreConf();
	switch($_GET['updateto']){
		case '1.0.9':
			$append['defaultPlugin'] = 'page';
			if(!saveConfig($coreConf, $append)) $error = true;
			break;
	}
	if($error){
		$data['msg'] = "Problème lors de la mise à jour";
		$data['msgType'] = "error";
	}
	else{
		$data['msg'] = "Mise à jour effectuée";
		$data['msgType'] = "success";
	}
}
else{
	if(file_exists(ROOT.'data/config.txt')){
		die();
	}
	@unlink(ROOT.'.htaccess');
	if(!@file_put_contents(ROOT.'.htaccess', "Options -Indexes", 0666)) $error = true;
	if(!@mkdir('data/', 0777)) $error = true;
	if(!@chmod('data/', 0777)) $error = true;
	if(!@mkdir('data/plugin/', 0777)) $error = true;
	if(!@chmod('data/plugin/', 0777)) $error = true;
	if(!@mkdir('data/upload/', 0777)) $error = true;
	if(!@chmod('data/upload/', 0777)) $error = true;
	$config = array(
		'siteName' => "Démo",
		'siteDescription' => "Un site propulsé par 99Ko",
		'adminPwd' => sha1('demo123'),
		'theme' => 'default',
		'adminEmail'=> 'you@domain.com',
		'siteUrl' => getSiteUrl(),
		'defaultPlugin' => 'page',
	);
	if(!@file_put_contents(ROOT.'data/config.txt', json_encode($config), 0666)) $error = true;
	if(!@chmod('data/config.txt', 0666)) $error = true;
	foreach(plugin::listAll() as $plugin){
		if($plugin->getLibFile()){
			include_once($plugin->getLibFile());
			if(!$plugin->isInstalled()) plugin::install($plugin->getName());
		}
	}
	if($error){
		$data['msg'] = "Problème lors de l'installation";
		$data['msgType'] = "error";
	}
	else{
		$data['msg'] = "99ko est installé\nLe mot de passe admin par défaut est : demo123\nModifiez-le dès votre première connexion\nSupprimez également le fichier install.php";
		$data['msgType'] = "success";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>99ko</title>
	<link href="common/normalize.css" rel="stylesheet" type="text/css" />
	<link href="admin/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<div id="header">
		<h1>99Ko</h1>
	</div>
	<div id="login">
		<h2>Installation</h2>
		<?php showMsg($data['msg'], $data['msgType']); ?>
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>
