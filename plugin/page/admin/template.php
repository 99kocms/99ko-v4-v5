<?php include_once(ROOT.'admin/header.php') ?>
<?php if($mode == 'list'){ ?>
<?php showMsg($msg, $msgType); ?>
<p><a href="index.php?p=page&action=edit">Ajouter</a></p>
<table>
	<tr>
		<th>Nom</th>
		<th>Adresse</th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($pageItems as $k=>$pageItem){ ?>
	<tr>
		<td><?php echo $pageItem->getName(); ?></td>
		<td><?php echo $coreConf['siteUrl']; ?>/index.php?p=page&id=<?php echo $pageItem->getId(); ?></td>
		<td><?php if($pageItem->getIshomepage()){ ?><img src="../plugin/page/house.png" alt="icon" title="Page d'accueil" /><?php } ?> <?php if($pageItem->getIsHidden()){ ?><img src="../plugin/page/bullet_orange.png" alt="icon" title="Cette page n'apparait pas dans le menu" /> <?php } ?></td>
		<td>
			<a href="index.php?p=page&action=edit&id=<?php echo $pageItem->getId(); ?>">editer</a>
			<?php if(!$pageItem->getIshomepage()){ ?> <a href="index.php?p=page&action=del&id=<?php echo $pageItem->getId(); ?>&token=<?php echo TOKEN; ?>" onclick = "if(!confirm('Supprimer cette page ?')) return false;">supprimer</a><?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
<?php } elseif($mode == 'edit'){ ?>
<form method="post" action="index.php?p=page&action=save">
	<?php showAdminTokenField(); ?>
	<input type="hidden" name="id" value="<?php echo $pageItem->getId(); ?>" />
	<p><label>Nom</label><br />
	<input type="text" name="name" value="<?php echo $pageItem->getName(); ?>" /></p>
	<p><label>URL de la page (facultatif)</label><br />
	<input type="text" name="url" value="<?php echo $pageItem->getUrl(); ?>" /></p>
	<p><label>Titre de la page (facultatif)</label><br />
	<input type="text" name="mainTitle" value="<?php echo $pageItem->getMainTitle(); ?>" /></p>
	<p><label>Balise meta title (facultatif)</label><br />
	<input type="text" name="metaTitleTag" value="<?php echo $pageItem->getMetaTitleTag(); ?>" /></p>
	<p><label>Balise meta description (facultatif)</label><br />
	<input type="text" name="metaDescriptionTag" value="<?php echo $pageItem->getMetaDescriptionTag(); ?>" /></p>
	<p><label>Position du lien dans la navigation</label><br />
	<input type="text" name="position" value="<?php echo $pageItem->getPosition(); ?>" /></p>
	<p><input <?php if($pageItem->getIshomepage()){ ?>checked<?php } ?> type="checkbox" name="isHomepage" /> Utiliser comme page d'accueil<br />
	<input <?php if($pageItem->getIsHidden()){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> Ne pas afficher de lien vers cette page dans le menu</p>
	<p><label>Contenu</label><br />
	<?php showAdminEditor('content', $pageItem->getContent(), '600', '400'); ?></p>
	<p><label>Inclure un fichier à la place du contenu</label><br />
		./theme/<?php echo $coreConf['theme']; ?>/ <select name="file">
			<option value="">--</option>
			<?php foreach($page->listFiles() as $file){ ?>
			<option <?php if($file == $pageItem->getFile()){ ?>selected<?php } ?> value="<?php echo $file; ?>"><?php echo $file; ?></option>
			<?php } ?>
		</select>
	</p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php include_once(ROOT.'admin/footer.php') ?>