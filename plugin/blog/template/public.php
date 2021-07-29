<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(THEMES .$core->getConfigVal('theme').'/header.php') ?>

<?php if($mode == 'list'){ ?>
<ul class="items <?php if($runPlugin->getConfigVal('hideContent')){ ?>simple<?php } ?>">
	<?php foreach($news as $k=>$v){ ?>
	<li class="item">
		<?php if(!$runPlugin->getConfigVal('hideContent')){ ?>
		<h2>
			<a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
			<p class="date"><?php echo $v['date']; ?>
			<?php if($runPlugin->getConfigVal('comments') && !$v['commentsOff']){ ?> | <?php echo $newsManager->countComments($v['id']); ?> commentaire<?php if ($newsManager->countComments($v['id']) > 1) echo 's' ?><?php } ?></p>
		</h2>
		<?php
		if($pluginsManager->isActivePlugin('galerie') && galerie::searchByfileName($v['img'])) echo '<img class="featured" src="'.UPLOAD.'galerie/'.$v['img'].'" alt="'.$v['img'].'" />';
		echo $v['content'];
		} else{ ?>
		<h2>
			<a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
		</h2>
		<p class="date"><?php echo $v['date']; ?><?php if($runPlugin->getConfigVal('comments') && !$v['commentsOff']){ ?> | <?php echo $newsManager->countComments($v['id']); ?> commentaire<?php if ($newsManager->countComments($v['id']) > 1) echo 's' ?><?php } ?></p>
		<?php } ?>
	</li>
	<?php } ?>
</ul>
<ul class="pagination">
	<?php foreach($pagination as $k=>$v){ ?>
	<li><a href="<?php echo $v['url']; ?>"><?php echo $v['num']; ?></a></li>
	<?php } ?>
</ul>
<?php } ?>

<?php if($mode == 'list_empty'){ ?>
<p>Aucun élément n'a été trouvé.</p>
<?php } ?>

<?php if($mode == 'read'){ ?>
<p class="date">
	Posté le <?php echo util::FormatDate($item->getDate(), 'en', 'fr'); ?>
	<?php if($runPlugin->getConfigVal('comments') && !$item->getCommentsOff()){ ?> | <?php echo $newsManager->countComments(); ?> commentaire<?php if ($newsManager->countComments($item->getId()) > 1) echo 's' ?><?php } ?>
	| <a href="<?php echo $runPlugin->getPublicUrl(); ?>">Retour à la liste</a>
</p>
<div class="content">
<?php if($pluginsManager->isActivePlugin('galerie') && galerie::searchByfileName($item->getImg())) echo '<img class="featured" src="'.UPLOAD.'galerie/'.$item->getImg().'" alt="'.$item->getName().'" />';
echo $item->getContent();
?>
</div>
<?php if($runPlugin->getConfigVal('comments') && !$item->getCommentsOff()){ ?>

<h2>Commentaires</h2>
<?php if($newsManager->countComments() == 0){ ?><p>Il n'y a pas de commentaires</p><?php } ?>
<?php if($newsManager->countComments() > 0){
	foreach($newsManager->getComments() as $k=>$v){
?>
<p class="comment" id="comment<?php echo $v->getId(); ?>"><?php echo nl2br($v->getContent()); ?><br><span class="infos"><?php echo $v->getAuthor(); ?> | <?php echo util::FormatDate($v->getDate(), 'en', 'fr'); ?></span></p>
<?php
	}
}
?>
<h2>Ajouter un commentaire</h2>
<form method="post" action="<?php echo $runPlugin->getPublicUrl(); ?>send.html">
	<input type="hidden" name="id" value="<?php echo $item->getId(); ?>" />
	<input type="hidden" name="back" value="<?php echo $runPlugin->getPublicUrl().util::strToUrl($item->getName()).'-'.$item->getId().'.html'; ?>" />
	<p>
		<label>Pseudo</label><br>
		<input style="display:none;" type="text" name="_author" value="" />
		<input type="text" name="author" required="required" />
	</p>
	<p><label>Email</label><br><input type="text" name="authorEmail" required="required" /></p>
	<p><label>Commentaire</label><br><textarea name="content" required="required"></textarea></p>
	<?php echo $antispamField; ?>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php } ?>

<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>