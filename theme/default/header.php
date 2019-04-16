<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php showTitleTag(); ?></title>
	<meta name="description" content="<?php showMetaDescriptionTag(); ?>" />
	<?php showLinkTags(); ?>
	<?php showScriptTags(); ?>
	<?php eval(callHook('endFrontHead')); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<p id="siteName"><a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>"><?php showSiteName(); ?></a></p>
	</div>
	<div id="sidebar">
		<ul id="navigation">
			<?php showMainNavigation(); ?>
		</ul>
	</div>
	<div id="body">
		<?php showBreadcrumb(); ?>
		<h1><?php showMainTitle(); ?></h1>
