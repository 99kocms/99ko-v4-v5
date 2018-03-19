<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<?php if($mode == 'list'){ ?>
<ul class="tabs_style">
  <li><a class="button" href="index.php?p=news&action=edit">Ajouter</a></li>
  <li><a target="_blank" class="button" href="../<?php echo $core->makeUrl('news', array('action' => 'rss')); ?>">Flux RSS</a></li>
</ul>
<table>
  <tr>
    <th>Titre</th>
    <th>Date</th>
    <th>Commentaires</th>
    <th></th>
  </tr>
  <?php foreach($newsManager->getItems() as $k=>$v){ ?>
  <tr>
    <td><?php echo $v->getName(); ?></td>
    <td><?php echo util::formatDate($v->getDate(), 'en', 'fr'); ?></td>
    <td><?php echo $newsManager->countComments($v->getId()); ?></td>
    <td>
      <a href="index.php?p=news&action=edit&id=<?php echo $v->getId(); ?>" class="button">Modifier</a>
			<a href="index.php?p=news&action=del&id=<?php echo $v->getId(); ?>&token=<?php echo administrator::getToken(); ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>

<?php if($mode == 'edit'){ ?>
<form method="post" action="index.php?p=news&action=save">
  <?php show::adminTokenField(); ?>
  <input type="hidden" name="id" value="<?php echo $news['id']; ?>" />
  
  <p>
      <input <?php if($news['draft']){ ?>checked<?php } ?> type="checkbox" name="draft" /> Ne pas publier (brouillon)
    </p>
  
  <p>
      <label>Titre</label><br>
      <input type="text" name="name" value="<?php echo $news['name']; ?>" required="required" />
    </p>
  <?php if($showDate){ ?>
    <p>
      <label>Date</label><br>
      <input placeholder="Exemple : 2017-07-06 12:28:51" type="date" name="date" value="<?php echo $news['date']; ?>" required="required" />
    </p>
  <?php } ?>
  
  <p>
      <label>Contenu</label><br>
      <textarea name="content" class="editor"><?php echo $news['content']; ?></textarea>
    </p>
  
  <p><button type="submit" class="button">Enregistrer</button></p>
</form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>