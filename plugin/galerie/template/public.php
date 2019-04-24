<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES .$core->getConfigVal('theme').'/header.php');
?>
<!-- Intro -->
<?= $runPlugin->getConfigVal('introduction') ?>

<!-- Categories -->
<?php if($galerie->useCategories()){ ?>
<ul class="categories">
    <?php if(count($galerie->listCategories(false)) > 0){ ?><li><a rel="category_all" href="javascript:">Afficher tout</a></li><?php } ?>
    <?php foreach($galerie->listCategories(false) as $k=>$v){ ?>
    <li><a rel="category_<?= util::strToUrl($v) ?>" href="javascript:"><?= $v ?></a></li>
    <?php } ?>
</ul>
<?php } ?>

<!-- Liste -->
<ul id="list">
    <?php foreach($galerie->getItems() as $k=>$obj) if(!$obj->getHidden()){ ?>
    <li class="category_<?= util::strToUrl($obj->getCategory()) ?> category_all" style="background-image:url(<?= UPLOAD ?>galerie/<?= $obj->getImg() ?>);">
        <a href="<?= UPLOAD ?>galerie/<?= $obj->getImg() ?>" data-lightbox="portfolio" data-title="<?= $obj->getTitle() ?><br><?= $obj->getCategory() ?><br><?= htmlentities($obj->getContent()) ?>">
        <?php if($runPlugin->getConfigVal('showTitles')){ ?><span><?= $obj->getTitle() ?></span><?php } ?>
        </a>
    </li>
    <?php } ?>
</ul>
<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>
