<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(THEMES .$core->getConfigVal('theme').'/header.php') ?>

<?php if($mode == 'list'){ ?>
<ul class="items <?php if($runPlugin->getConfigVal('hideContent')){ ?>simple<?php } ?>">
	<?php foreach($news as $k=>$v){ ?>
	<li class="item">
		<?php if(!$runPlugin->getConfigVal('hideContent')){ ?>
		<h2>
			<a href="<?= $v['url'] ?>"><?= $v['name'] ?></a>
			<span class="date"><?= $v['date'] ?>
			<?php if($runPlugin->getConfigVal('comments')){ ?> | <?= $newsManager->countComments($v['id']) ?> commentaire(s)<?php } ?></span>
		</h2>
		<?php
		if($pluginsManager->isActivePlugin('galerie') && galerie::searchByfileName($v['img'])) echo '<img class="featured" src="'.UPLOAD.'galerie/'.$v['img'].'" alt="'.$v['img'].'" />';
		echo $v['content'];
		} else{ ?>
		<a href="<?= $v['url'] ?>"><?= $v['name'] ?></a> <span class="date"><?= $v['date'] ?><?php if($runPlugin->getConfigVal('comments')){ ?> | <?php echo $newsManager->countComments($v['id']); ?> commentaire(s)<?php } ?></span>
		<?php } ?>
	</li>
	<?php } ?>
</ul>
<ul class="pagination">
	<?php foreach($pagination as $k=>$v){ ?>
	<li><a href="<?= $v['url'] ?>"><?= $v['num'] ?></a></li>
	<?php } ?>
</ul>
<?php } ?>

<?php if($mode == 'read'){
if($pluginsManager->isActivePlugin('galerie') && galerie::searchByfileName($item->getImg())) echo '<img class="featured" src="'.UPLOAD.'galerie/'.$item->getImg().'" alt="'.$item->getName().'" />';
echo $item->getContent();
?>
<p class="date">
	Posté le <?= util::FormatDate($item->getDate(), 'en', 'fr') ?>
	<?php if($runPlugin->getConfigVal('comments')){ ?> | <?= $newsManager->countComments() ?> commentaire<?= (($newsManager->countComments() == 1) ? "s" : "") ?><?php } ?>
	| <a href="<?= $core->makeUrl('news') ?>">Retour à la liste</a>
</p>
<?php if($runPlugin->getConfigVal('comments')){ ?>

<h2>Commentaires</h2>
<?php if($newsManager->countComments() == 0){ ?><p>Il n'y a pas de commentaires</p><?php } ?>
<?php if($newsManager->countComments() > 0){
	foreach($newsManager->getComments() as $k=>$v){
?>
<p class="comment" id="comment<?= $v->getId() ?>"><?= nl2br($v->getContent()) ?><br><span class="infos"><?= $v->getAuthor() ?> | <?= util::FormatDate($v->getDate(), 'en', 'fr') ?></span></p>
<?php
	}
}
?>
<h2>Ajouter un commentaire</h2>
<form method="post" action="<?= $core->makeUrl('news', array('action' => 'send')) ?>">
	<input type="hidden" name="id" value="<?= $item->getId() ?>" />
	<input type="hidden" name="back" value="<?= $core->getConfigVal('siteUrl').'/'.$core->makeUrl('news', array('action' => 'read', 'name' => util::strToUrl($item->getName()), 'id' => $item->getId())) ?>" />
	<p>
		<label>Pseudo</label><br>
		<input style="display:none;" type="text" name="_author" value="" />
		<input type="text" name="author" required="required" />
	</p>
	<p><label>Email</label><br><input type="text" name="authorEmail" required="required" /></p>
	<p><label>Commentaire</label><br><textarea name="content" required="required"></textarea></p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php } ?>

<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>
