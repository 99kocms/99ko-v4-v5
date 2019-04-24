<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<?php if($mode == 'list'){ ?>

<ul class="tabs_style">
  <li><a class="button" href="index.php?p=page&amp;action=edit">Ajouter une page</a></li>
  <li><a class="button" href="index.php?p=page&amp;action=edit&parent=1">Ajouter un item parent</a></li>
  <li><a class="button" href="index.php?p=page&amp;action=edit&link=1">Ajouter un lien externe</a></li>
</ul>
<?php if($lost != ''){ ?>
<p>Des pages "fantômes" pouvant engendrer des dysfonctionnements ont été trouvées. <a href="index.php?p=page&amp;action=maintenance&id=<?= $lost ?>&token=<?= administrator::getToken() ?>">Cliquez ici</a> pour exécuter le script de maintenance.</p>
<?php } ?>
<table>
  <thead>
	<tr>
		<th></th>
		<th>Nom</th>
		<th>Adresse</th>
		<th>Position</th>
		<th></th>
	</tr>
  </thead>
  <tbody>
	<?php foreach($page->getItems() as $k=>$pageItem) if($pageItem->getParent() == 0 && ($pageItem->targetIs() != 'plugin' || ($pageItem->targetIs() == 'plugin' && $pluginsManager->isActivePlugin($pageItem->getTarget())))){ ?>
	<tr>
		<td><?php if($pageItem->getIsHomepage()){ ?><img title="Accueil" src="<?= PLUGINS ?>page/template/house.png" alt="icon" /><?php } ?> 
		    <?php if($pageItem->getIsHidden()){ ?><img title="N'apparait pas dans le menu" src="<?= PLUGINS ?>page/template/ghost.png" alt="icon" /><?php } ?>
			<?php if($pageItem->targetIs() == 'url'){ ?><img title="Externe" src="<?= PLUGINS ?>page/template/link.png" alt="icon" /><?php } ?>
			<?php if($pageItem->targetIs() == 'plugin'){ ?><img title="Plugin" src="<?= PLUGINS ?>page/template/plugin.png" alt="icon" /><?php } ?>
			<?php if($pageItem->targetIs() == 'parent'){ ?><img title="Parent" src="<?= PLUGINS ?>page/template/star.png" alt="icon" /><?php } ?>
		</td>
		<td><?= $pageItem->getName() ?></td>
		<td><?php if($pageItem->targetIs() != 'parent'){ ?><input readonly="readonly" type="text" value="<?= $page->makeUrl($pageItem) ?>" /><?php } ?></td>
		<td>
		  <a class="up" href="index.php?p=page&action=up&id=<?= $pageItem->getId() ?>&token=<?= administrator::getToken() ?>"><img src="<?= PLUGINS ?>page/template/up.png" alt="icon" /></a>&nbsp;&nbsp;
		  <a class="down" href="index.php?p=page&action=down&id=<?= $pageItem->getId() ?>&token=<?= administrator::getToken() ?>"><img src="<?= PLUGINS ?>page/template/down.png" alt="icon" /></a>
		</td>
		<td>
		  <a class="button" href="index.php?p=page&amp;action=edit&amp;id=<?= $pageItem->getId() ?>">Modifier</a> 
          <?php if(!$pageItem->getIsHomepage() && $pageItem->targetIs() != 'plugin'){ ?><a class="button alert" href="index.php?p=page&amp;action=del&amp;id=<?= $pageItem->getId(). '&amp;token=' .administrator::getToken() ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;">Supprimer</a><?php } ?>	
		</td>
	</tr>
	<?php foreach($page->getItems() as $k=>$pageItemChild) if($pageItemChild->getParent() == $pageItem->getId() && ($pageItemChild->targetIs() != 'plugin' || ($pageItemChild->targetIs() == 'plugin' && $pluginsManager->isActivePlugin($pageItemChild->getTarget())))){ ?>
	<tr>
		<td><?php if($pageItemChild->getIsHomepage()){ ?><img title="Accueil" src="<?= PLUGINS ?>page/template/house.png" alt="icon" /><?php } ?> 
			<?php if($pageItemChild->getIsHidden()){ ?><img title="N'apparait pas dans le menu" src="<?= PLUGINS ?>page/template/ghost.png" alt="icon" /><?php } ?>
			<?php if($pageItemChild->targetIs() == 'url'){ ?><img title="Externe" src="<?= PLUGINS ?>page/template/link.png" alt="icon" /><?php } ?>
			<?php if($pageItemChild->targetIs() == 'plugin'){ ?><img title="Plugin" src="<?= PLUGINS ?>page/template/plugin.png" alt="icon" /><?php } ?>
			<?php if($pageItemChild->targetIs() == 'parent'){ ?><img title="Parent" src="<?= PLUGINS ?>page/template/star.png" alt="icon" /><?php } ?>
		</td>
		<td>▸ <?= $pageItemChild->getName() ?></td>
		<td><input readonly="readonly" type="text" value="<?= $page->makeUrl($pageItemChild) ?>" /></td>
		<td>
		  <a class="up" href="index.php?p=page&action=up&id=<?= $pageItemChild->getId() ?>&token=<?= administrator::getToken() ?>"><img src="<?= PLUGINS ?>page/template/up.png" alt="icon" /></a>&nbsp;&nbsp;
		  <a class="down" href="index.php?p=page&action=down&id=<?= $pageItemChild->getId() ?>&token=<?= administrator::getToken() ?>"><img src="<?= PLUGINS ?>page/template/down.png" alt="icon" /></a>
		</td>
		<td>
		  <a class="button" href="index.php?p=page&amp;action=edit&amp;id=<?= $pageItemChild->getId() ?>">Modifier</a> 
		  <?php if(!$pageItemChild->getIsHomepage() && $pageItemChild->targetIs() != 'plugin'){ ?><a class="button alert" href="index.php?p=page&amp;action=del&amp;id=<?= $pageItemChild->getId(). '&amp;token=' .administrator::getToken() ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;">Supprimer</a><?php } ?>	
		</td>
	</tr>
	<?php } } ?>
  </tbody>
</table>
<?php } ?>

<?php if($mode == 'edit' && !$isLink && !$isParent && $pageItem->targetIs() != 'plugin'){ ?>
<form method="post" action="index.php?p=page&amp;action=save" enctype="multipart/form-data">
  <?php show::adminTokenField(); ?>
  <input type="hidden" name="id" value="<?= $pageItem->getId() ?>" />
	<?php if($pluginsManager->isActivePlugin('galerie')){ ?>
  <input type="hidden" name="imgId" value="<?= $pageItem->getImg() ?>" />
	<?php } ?>
	<h3>Paramètres</h3>
  <p>
      <input <?php if($pageItem->getIsHomepage()){ ?>checked<?php } ?> type="checkbox" name="isHomepage" /> Page d'accueil
	</p>
	<p>
      <input <?php if($pageItem->getIsHidden()){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> Ne pas afficher dans le menu
	</p>
  <p>
      <label>Item parent</label><br>
	  <select name="parent">
	  <option value="">Aucun</option>
	  <?php foreach($page->getItems() as $k=>$v) if($v->targetIs() == 'parent'){ ?>
	  <option <?php if($v->getId() == $pageItem->getParent()){ ?>selected<?php } ?> value="<?= $v->getId() ?>"><?= $v->getName() ?></option>
	  <?php } ?>
	  </select>
  </p>
  <p>
      <label>Classe CSS</label>
      <input type="text" name="cssClass" value="<?= $pageItem->getCssClass() ?>" />
  </p>
  <p>
      <label>Position</label>
      <input type="number" name="position" value="<?= $pageItem->getPosition() ?>" />
  </p>
  <p>
      <label>Restreindre l'accès avec un mot de passe</label>
      <input type="password" name="_password" value="" />
  </p>
  <?php if($pageItem->getPassword() != ''){ ?>
  <p>
    <input type="checkbox" name="resetPassword" /> Retirer la restriction par mot de passe  
  </p>
  <?php } ?>
	<h3>SEO</h3>
	<p>
      <input <?php if($pageItem->getNoIndex()){ ?>checked<?php } ?> type="checkbox" name="noIndex" /> Interdire l'indexation
  </p>
  <p>
      <label>Meta title</label>
      <input type="text" name="metaTitleTag" value="<?= $pageItem->getMetaTitleTag() ?>" />
  </p>
  <p>
      <label>Meta description</label>
      <input type="text" name="metaDescriptionTag" value="<?= $pageItem->getMetaDescriptionTag() ?>" />
  </p>
	<h3>Contenu</h3>
  <p>
      <label>Nom</label><br>
      <input type="text" name="name" value="<?= $pageItem->getName() ?>" required="required" />
  </p>
  <p>
      <label>Titre de page</label><br>
      <input type="text" name="mainTitle" value="<?= $pageItem->getMainTitle() ?>" />
  </p>
  <p>
      <label>Inclure un fichier .php au lieu du contenu
	  <select name="file" class="large-3 columns">
		  <option value="">--</option>
		  <?php foreach($page->listTemplates() as $file){ ?>
		  <option <?php if($file == $pageItem->getFile()){ ?>selected<?php } ?> value="<?= $file ?>"><?= $file ?></option>
		  <?php } ?>
	  </select>
  </p>
  <p>
      <label>Contenu</label>
			<textarea name="content" class="editor"><?= $pageItem->getContent() ?></textarea>
  </p>
	<?php if($pluginsManager->isActivePlugin('galerie')){ ?>
	<h3>Image à la une</h3>
	<p>
      <label>Fichier (jpg)</label><br>
      <input type="file" name="file" />
      <br>
      <?php if(galerie::searchByfileName($pageItem->getImg())){ ?><img src="<?= UPLOAD ?>galerie/<?= $pageItem->getImg() ?>" alt="<?= $pageItem->getImg() ?>" /><?php } ?>
    </p>
	<?php } ?>
  <p>
	<button type="submit" class="button success radius">Enregistrer</button>
  </p>
</form>
<?php } ?>

<?php if($mode == 'edit' && ($isLink || $pageItem->targetIs() == 'plugin')){ ?>
<form method="post" action="index.php?p=page&amp;action=save">
  <?php show::adminTokenField(); ?>
  <input type="hidden" name="id" value="<?= $pageItem->getId() ?>" />
  <!--<input type="hidden" name="position" value="<?= $pageItem->getPosition() ?>" />-->
  <p>
      <input <?php if($pageItem->getIsHidden()){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> <label for="isHidden">Ne pas afficher dans le menu</label>
  </p>
  <p>
      <label>Item parent</label><br>
	  <select name="parent">
	  <option value="">Aucun</option>
	  <?php foreach($page->getItems() as $k=>$v) if($v->targetIs() == 'parent'){ ?>
	  <option <?php if($v->getId() == $pageItem->getParent()){ ?>selected<?php } ?> value="<?= $v->getId() ?>"><?= $v->getName() ?></option>
	  <?php } ?>
	  </select>
  </p>
  <p>
      <label>Nom</label><br>
      <input type="text" name="name" value="<?= $pageItem->getName() ?>" required="required" />
  </p>
  <?php if($pageItem->targetIs() == 'plugin'){ ?>
  <p>
      <label>Cible : <?= $pageItem->getTarget() ?></label>
      <input style="display:none;" type="text" name="target" value="<?= $pageItem->getTarget() ?>" />
  </p>
  <?php } else{ ?>
  <p>
      <label>Cible</label><br>
      <input placeholder="Example : http://www.google.com" <?php if($pageItem->targetIs() == 'plugin'){ ?>readonly<?php } ?> type="url" name="target" value="<?= $pageItem->getTarget() ?>" required="required" />
  </p>
  <?php } ?>
  <p>
      <label>Ouverture</label><br>
	  <select name="targetAttr">
		<option value="_self" <?php if($pageItem->getTargetAttr() == '_self'){ ?>selected<?php } ?>>Même fenêtre</option>
		<option value="_blank" <?php if($pageItem->getTargetAttr() == '_blank'){ ?>selected<?php } ?>>Nouvelle fenêtre</option>
	  </select>
  </p>
  <p>
      <label>Classe CSS</label>
      <input type="text" name="cssClass" value="<?= $pageItem->getCssClass() ?>" />
  </p>
  <p>
      <label>Position</label>
      <input type="number" name="position" value="<?= $pageItem->getPosition() ?>" />
  </p>
  <p>
	<button type="submit" class="button success radius">Enregistrer</button>
  </p>
</form>
<?php } ?>

<?php if($mode == 'edit' && $isParent){ ?>
<form method="post" action="index.php?p=page&amp;action=save">
  <?php show::adminTokenField(); ?>
  <input type="hidden" name="id" value="<?= $pageItem->getId() ?>" />
  <!--<input type="hidden" name="position" value="<?= $pageItem->getPosition() ?>" />-->
  <input type="hidden" name="target" value="javascript:" />
  <p>
      <input <?php if($pageItem->getIsHidden()){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> <label for="isHidden">Ne pas afficher dans le menu</label>
  </p>
  <p>
      <label>Nom</label><br>
      <input type="text" name="name" value="<?= $pageItem->getName() ?>" required="required" />
  </p>
  <p>
      <label>Classe CSS</label>
      <input type="text" name="cssClass" value="<?= $pageItem->getCssClass() ?>" />
  </p>
  <p>
      <label>Position</label>
      <input type="number" name="position" value="<?= $pageItem->getPosition() ?>" />
  </p>
  <p>
	<button type="submit" class="button success radius">Enregistrer</button>
  </p>
</form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>
