<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>99ko</title>
	<?php showLinkTags(); ?>
	<?php showScriptTags(); ?>
	<?php eval(callHook('endAdminHead')); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>99Ko <a target="_blank" href="../">Voir le site</a> <a href="index.php?action=logout&token=<?php echo $data['token']; ?>">Se déconnecter</a> <a href="index.php">Accueil administration</a></h1>
	</div>
	<div id="config" onclick="closePlugins();openConfig()">
		<h2>Configuration</h2>
		<form id="configForm" method="post" action="index.php?action=saveconfig&opentab=config">
			<?php showMsg($data['msgConfig'], 'error'); ?>
			<?php showAdminTokenField(); ?>
			<p><label>Nom du site</label><br />
			<input type="text" name="siteName" value="<?php echo $data['configSiteName']; ?>" /></p>
			<p><label>Description du site</label><br />
			<input type="text" name="siteDescription" value="<?php echo $data['configSiteDescription']; ?>" /></p>
			<p><label>Email admin</label><br />
			<input type="text" name="adminEmail" value="<?php echo $data['configAdminEmail']; ?>" /></p>
			<p><label>Thème</label><br />
			<select name="theme">
				<?php foreach($data['configThemes'] as $theme){ ?>
				<option <?php if($theme['selected']){ ?>selected<?php } ?> value="<?php echo $theme['name']; ?>"><?php echo $theme['name']; ?></option>
				<?php } ?>
			</select></p>
			<p><label>Plugin par défaut</label><br />
			<select name="defaultPlugin">
				<?php foreach($data['plugins'] as $plug) if($plug['target'] && $plug['activate'] && $plug['frontFile']){ ?>
				<option <?php if($plug['isDefaultPlugin']){ ?>selected<?php } ?> value="<?php echo $plug['id']; ?>"><?php echo $plug['name']; ?></option>
				<?php } ?>
			</select></p>
			
			<p><label>URL du site</label><br />
			<input type="text" name="siteUrl" value="<?php echo $data['configSiteUrl']; ?>" /> (sans slash final)</p>
			<p><label>Nouveau mot de passe admin</label><br />
			<input type="password" name="adminPwd" value="" /> confirmation : <input type="password" name="adminPwd2" value="" /></p>
			<p><input type="submit" value="Enregistrer" /></p>
		</form>
	</div>
	<div id="plugins" onclick="closeConfig();openPlugins()">
		<h2>Plugins</h2>
		<form method="post" action="index.php?action=saveplugins&opentab=plugins" id="pluginsList">
			<?php showMsg($data['msgPlugins'], 'error'); ?>
			<?php showAdminTokenField(); ?>
			<table>
				<tr>
					<th>Nom</th>
					<th>Description</th>
					<th>Version</th>
					<th>Priorité</th>
					<th>Activer</th>
				</tr>
				<?php foreach($data['plugins'] as $plug){ ?>
				<tr>
					<td>
						<?php if($plug['target'] && $plug['activate']){ ?>
						<a href="<?php echo $plug['target']; ?>"><?php echo $plug['name']; ?></a>
						<?php } else{ 
						echo $plug['name'];
						} ?>
					</td>
					<td><?php echo $plug['description']; ?><br />
					<span class="infos">Par <?php echo $plug['author']; ?> : <?php echo $plug['authorEmail']; ?> <a href="<?php echo $plug['authorWebsite']; ?>" target="_blank"><?php echo $plug['authorWebsite']; ?></a></span></td>
					<td><?php echo $plug['version']; ?></td>
					<td><input class="priority" type="text" name="priority[<?php echo $plug['id']; ?>]" value="<?php echo $plug['priority']; ?>" /></td>
					<td><input <?php if($plug['isDefaultPlugin']){ ?>style="display:none;"<?php } ?> <?php if($plug['activate']){ ?>checked<?php } ?> type="checkbox" name="activate[<?php echo $plug['id']; ?>]" /></td>
				</tr>
				<?php } ?>
			</table>
			<p><input type="submit" value="Enregistrer" /></p>
		</form>
	</div>
	<div id="body" onclick="closePlugins();closeConfig();">
		<h2><?php echo $data['mainTabTitle']; ?></h2>
		<p class="pluginsAccess">
			<select onchange="document.location.href='index.php?p='+this.value">
				<option value="">Accès rapide</option>
				<?php foreach($data['plugins'] as $plug) if($plug['target'] && $plug['activate']){ ?>
				<option value="<?php echo $plug['id']; ?>">Plugin <?php echo $plug['name']; ?></option>
				<?php } ?>
			</select>
		</p>
		<div class="cleared"></div>
