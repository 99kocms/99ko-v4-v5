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

session_start();
define('ROOT', './');
include_once(ROOT.'common/config.php');
include_once(COMMON.'util.class.php');
include_once(COMMON.'core.class.php');
include_once(COMMON.'pluginsManager.class.php');
include_once(COMMON.'plugin.class.php');
include_once(COMMON.'show.class.php');
include_once(COMMON.'administrator.class.php');
if(file_exists(DATA. 'config.json')) die('Un fichier de configuration existe déjà !');
$core = core::getInstance();
$administrator = new administrator();
$pluginsManager = pluginsManager::getInstance();
$msg = "Après l'installation, vous serez redirigé vers la page d'identification afin de paramétrer votre site.";
if($core->install()){
	$plugins = $pluginsManager->getPlugins();
	if($plugins != false){
		foreach($plugins as $plugin){
		  if($plugin->getLibFile()){
			include_once($plugin->getLibFile());
			if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName(), true);
			$plugin->setConfigVal('activate', '1');
			$pluginsManager->savePluginConfig($plugin);
		  }
		}
	}
}
if(count($_POST) > 0 && $administrator->isAuthorized()){
	$adminPwd = $administrator->encrypt($_POST['adminPwd']); 
    $adminEmail = $_POST['adminEmail'];
	$config = array(
		'siteName' => "Nom du site",
		'adminPwd' => $administrator->encrypt($_POST['adminPwd']),
		'adminEmail' => $_POST['adminEmail'],
		'siteUrl' => $core->makeSiteUrl(),      
		'theme' => 'default',
		'hideTitles' => '0',
		'defaultPlugin' => 'page',
		'debug' => '0',
		'defaultAdminPlugin' => 'page',
	);
	if(!@file_put_contents(DATA. 'config.json', json_encode($config)) ||	!@chmod(DATA. 'config.json', 0666)){
		$msg = 'Une erreur est survenue';
	}
	else{
		$_SESSION['installOk'] = true;
		header('location:admin/');
		die();
	}
}
?>
 
 <!doctype html>
<html lang="fr">
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>99ko - Installation</title>	
	<link rel="stylesheet" href="admin/styles.css" media="all">
  </head>
  
  <body class="login">
	<?php show::msg($msg); ?>
	<div id="login">
           <h1 class="text-center">Installation</h1>
           
           <form method="post" action="">   
           <?php show::adminTokenField(); ?>          
              <p>
                   <label for="adminEmail">Email</label><br>
                   <input type="email" name="adminEmail" required="required">
                </p><p>
                   <label for="adminPwd">Mot de passe</label><br>
                   <input type="password" name="adminPwd" id="adminPwd" required="required">
               </p><p>
					<a id="showPassword" href="javascript:showPassword()" class="button success">Montrer le mot de passe</a>
					<button type="submit" class="button success">Valider</button>
			  </p>
			  <p class="just_using"><a target="_blank" href="https://github.com/99kocms/">Just using 99ko</a>
	  </p>
            </form>
	</div>
    <script type="text/javascript">
	function showPassword(){
		document.getElementById("adminPwd").setAttribute("type", "text");
		document.getElementById("showPassword").style.display = 'none';
	}
	</script>
</body>
</html>