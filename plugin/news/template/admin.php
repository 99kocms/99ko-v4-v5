<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<?php if($mode == 'list'){ ?>
<ul class="tabs_style">
  <li><a class="button" href="index.php?p=news&action=edit">Ajouter</a></li>
  <li><a target="_blank" class="button" href="../<?= $core->makeUrl('news', array('action' => 'rss')) ?>">Flux RSS</a></li>
</ul>
<table>
  <tr>
    <th>Titre</th>
    <th>Date</th>
    <th></th>
  </tr>
  <?php foreach($newsManager->getItems() as $k=>$v){ ?>
  <tr>
    <td><?= $v->getName() ?></td>
    <td><?= util::formatDate($v->getDate(), 'en', 'fr') ?></td>
    <td>
      <a href="index.php?p=news&action=edit&id=<?= $v->getId() ?>" class="button">Modifier</a>
      <?php if($newsManager->countComments($v->getId()) > 0){ ?><a href="index.php?p=news&action=listcomments&id=<?= $v->getId() ?>" class="button">Commentaires (<?= $newsManager->countComments($v->getId()) ?>)</a><?php } ?>
			<a href="index.php?p=news&action=del&id=<?= $v->getId() ?>&token=<?= administrator::getToken() ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>

<?php if($mode == 'edit'){ ?>
<form method="post" action="index.php?p=news&action=save" enctype="multipart/form-data">
  <?php show::adminTokenField(); ?>
  <input type="hidden" name="id" value="<?= $news['id'] ?>" />
  <?php if($pluginsManager->isActivePlugin('galerie')){ ?>
  <input type="hidden" name="imgId" value="<?= $news['img'] ?>" />
	<?php } ?>
	<h3>Paramètres</h3>
  <p>
      <input <?php if($news['draft']){ ?>checked<?php } ?> type="checkbox" name="draft" /> Ne pas publier (brouillon)
    </p>
  <h3>Contenu</h3>
  <p>
      <label>Titre</label><br>
      <input type="text" name="name" value="<?= $news['name'] ?>" required="required" />
    </p>
  <?php if($showDate){ ?>
    <p>
      <label>Date</label><br>
      <input placeholder="Exemple : 2017-07-06 12:28:51" type="date" name="date" value="<?= $news['date'] ?>" required="required" />
    </p>
  <?php } ?>
  
  <p>
      <label>Contenu</label><br>
      <textarea name="content" class="editor"><?= $news['content'] ?></textarea>
    </p>
	
	<?php if($pluginsManager->isActivePlugin('galerie')){ ?>
	<h3>Image à la une</h3>
	<p>
      <label>Fichier (jpg)</label><br>
      <input type="file" name="file" />
      <br>
      <?php if(galerie::searchByfileName($news['img'])){ ?><img src="<?= UPLOAD ?>galerie/<?= $news['img'] ?>" alt="<?= $news['img'] ?>" /><?php } ?>
    </p>
	<?php } ?>
  
  <p><button type="submit" class="button">Enregistrer</button></p>
</form>
<?php } ?>

<?php if($mode == 'listcomments'){ ?>
<ul class="tabs_style">
  <li><a class="button" href="index.php?p=news">Retour</a></li>
</ul>
<table>
  <tr>
    <th>Commentaire</th>
    <th></th>
  </tr>
  <?php foreach($newsManager->getComments() as $k=>$v){ ?>
  <tr>
    <td>
      <?= $v->getAuthor() ?> <i><?= $v->getAuthorEmail() ?></i> - <?= util::formatDate($v->getDate(), 'en', 'fr') ?></b> :<br><br>
      <form id="comment<?= $v->getId() ?>" method="post" action="index.php?p=news&action=updatecomment&id=<?= $_GET['id'] ?>&idcomment=<?= $v->getId() ?>&token=<?= administrator::getToken() ?>"><textarea name="content<?= $v->getId() ?>"><?= $v->getContent() ?></textarea></form>
    </td>
    <td>
      <a onclick="updateComment(<?= $v->getId() ?>);" href="javascript:" class="button">Enregistrer</a>
			<a href="index.php?p=news&action=delcomment&id=<?= $_GET['id'] ?>&idcomment=<?= $v->getId() ?>&token=<?= administrator::getToken() ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
    </td>
  </tr>
  <?php } ?>
</table>
<script>
  function updateComment(id){
    document.getElementById('comment'+id).submit();
  }
</script>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>
