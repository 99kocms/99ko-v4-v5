<?php
if(!defined('ROOT')) die();
$page = new page();
$pageItem = (isset($_GET['id'])) ? $page->create($_GET['id']) : $page->createHomepage();
$runPlugin->setMainTitle(($pageItem->getMainTitle() == '') ? $pageItem->getName() : $pageItem->getMainTitle());
$runPlugin->setMetaDescriptionTag($pageItem->getMetaDescriptionTag());
$runPlugin->setMetaTitleTag(($pageItem->getMetaTitleTag() == '') ? $pageItem->getName() : $pageItem->getMetaTitleTag());
$runPlugin->setTitleTag($pageItem->getName());
?>

<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/header.php') ?>
<?php
if($pageItem->getFile()) include_once(ROOT.'theme/'.$coreConf['theme'].'/'.$pageItem->getFile());
else echo $pageItem->getContent();
?>
<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/footer.php') ?>
