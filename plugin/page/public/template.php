<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/header.php') ?>
<?php
if($pageItem->getFile()) include_once(ROOT.'theme/'.$coreConf['theme'].'/'.$pageItem->getFile());
else echo $pageItem->getContent();
?>
<?php include_once(ROOT.'theme/'.$coreConf['theme'].'/footer.php') ?>