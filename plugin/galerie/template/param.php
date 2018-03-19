<?php defined('ROOT') OR exit('No direct script access allowed'); ?>

<form method="post" action="index.php?p=galerie&action=saveconf">
  <?php show::adminTokenField(); ?>
  
  <p>
      <input <?php if($runPlugin->getConfigVal('showTitles')){ ?>checked<?php } ?> type="checkbox" name="showTitles" /> Afficher le titre des images 
    </p>
  
  <p>
      <label>Titre de page</label><br>
      <input type="text" name="label" value="<?php echo $runPlugin->getConfigVal('label'); ?>" />
    </p>
    <p>
      <label>Ordre des images</label><br>
      <select name="order">
        <option <?php if($runPlugin->getConfigVal('order') == 'natural'){ ?>selected<?php } ?> value="natural">Naturel</option>
        <option <?php if($runPlugin->getConfigVal('order') == 'byName'){ ?>selected<?php } ?> value="byName">Nom</option>
        <option <?php if($runPlugin->getConfigVal('order') == 'byDate'){ ?>selected<?php } ?> value="byDate">Date</option>
      </select>
    </p>
    <p>
      <label>Taille des images</label><br>
      <select name="size">
        <option <?php if($runPlugin->getConfigVal('size') == '800'){ ?>selected<?php } ?> value="800">Normale</option>
        <option <?php if($runPlugin->getConfigVal('size') == '1024'){ ?>selected<?php } ?> value="1024">Grande</option>
        <option <?php if($runPlugin->getConfigVal('size') == '1280'){ ?>selected<?php } ?> value="1280">Très grande</option>
      </select>
    </p>
  
  <p>
      <label>Introduction</label><br>
      <textarea class="editor" name="introduction"><?php echo $runPlugin->getConfigVal('introduction'); ?></textarea>
    </p>
  
  <p><button type="submit" class="button">Enregistrer</button></p>
</form>