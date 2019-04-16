<?php
if(!defined('ROOT')) die();
$pageItem = (isset($_GET['id'])) ? $page->create($_GET['id']) : $page->createHomepage();
$runPlugin->setMainTitle(($pageItem->getMainTitle() != '') ? $pageItem->getMainTitle() : $pageItem->getName());
if($pageItem->getMetaDescriptionTag() != '') $runPlugin->setMetaDescriptionTag($pageItem->getMetaDescriptionTag());
elseif($pageItem->getMetaDescriptionTag() == '' && $pageItem->getIsHomepage() && $runPlugin->getIsDefaultPlugin()) $runPlugin->setMetaDescriptionTag($coreConf['siteDescription']);
$pageTitleTag = $pageItem->getName();
if($pageItem->getMainTitle() != '') $pageTitleTag.= ' | '.$pageItem->getMainTitle();
$runPlugin->setTitleTag($pageTitleTag);
$runPlugin->removeToBreadcrumb(0);
$runPlugin->addToBreadcrumb($pageItem->getName(), 'index.php?p=page&id='.$pageItem->getId());
if($runPlugin->getIsDefaultPlugin() && $pageItem->getIsHomepage()) $runPlugin->initBreadcrumb();
$data['pageId'] = $pageItem->getId();
$data['pageName'] = $pageItem->getName();
$data['pageContent'] = $pageItem->getContent();
$data['pageFile'] = ($pageItem->getFile()) ? ROOT.'theme/'.$coreConf['theme'].'/'.$pageItem->getFile() : false;
?>

<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/header.php') ?>
<?php
if($data['pageFile']) include_once($data['pageFile']);
else echo $data['pageContent'];
?>
<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/footer.php') ?>
