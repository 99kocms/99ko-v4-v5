<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES.$core->getConfigVal('theme').'/header.php');
if($page->isUnlocked($pageItem)){
    if($pageItem->getFile()) include_once(THEMES.$core->getConfigVal('theme').'/'.$pageItem->getFile());
    else{
        if($pluginsManager->isActivePlugin('galerie') && galerie::searchByfileName($pageItem->getImg())) echo '<img class="featured" src="'.UPLOAD.'galerie/'.$pageItem->getImg().'" alt="'.$pageItem->getName().'" />';
        echo $pageItem->getContent();
    }
}
else{ ?>
<form method="post" action="<?= $core->makeUrl('page', array('name' => $pageItem->getName(), 'id' => $pageItem->getId(), 'action' => 'unlock')) ?>">
  <p>
    <label>Mot de passe</label><br>
    <input style="display:none;" type="text" name="_password" value="" />
    <input required="required" type="password" name="password" value="" />
  </p>
  <p>
    <input type="submit" value="Envoyer" />
  </p>
</form>
<?php }
include_once(THEMES.$core->getConfigVal('theme').'/footer.php');
?>
