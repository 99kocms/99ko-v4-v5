<?php if(!defined('ROOT')) die(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php showMetaTitleTag(); ?></title>
	<base href="<?php showSiteUrl(); ?>/" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<meta name="description" content="<?php showMetaDescriptionTag(); ?>" />
	<?php showLinkTags(); ?>
	<?php showScriptTags(); ?>
	<?php eval(callHook('endFrontHead')); ?>
</head>
<body class="plugin_<?php showPluginName(); ?>">
<div id="container">
	<div id="header">
		<p id="siteName"><a href="<?php showSiteUrl(); ?>"><?php showSiteName(); ?></a></p>
	</div>
	<div id="sidebar">
		<ul id="navigation">
			<?php showMainNavigation(); ?>
		</ul>
	</div>
	<div id="body">
		<h1><?php showMainTitle(); ?></h1>