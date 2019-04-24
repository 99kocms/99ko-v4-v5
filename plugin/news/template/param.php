<form method="post" action="index.php?p=news&action=saveconf">
  <?php show::adminTokenField(); ?>
  
  <p>
      <input <?php if($runPlugin->getConfigVal('hideContent')){ ?>checked<?php } ?> type="checkbox" name="hideContent" /> Masquer le contenu des articles dans la liste
    </p>
  <p>
      <input <?php if($runPlugin->getConfigVal('comments')){ ?>checked<?php } ?> type="checkbox" name="comments" /> Autoriser les commentaires
    </p>
  <p>
      <label>Titre de page</label><br>
      <input type="text" name="label" value="<?= $runPlugin->getConfigVal('label') ?>" />
    </p>
    <p
      <label>Nombre d'entrées par page</label><br>
      <input type="number" name="itemsByPage" value="<?= $runPlugin->getConfigVal('itemsByPage') ?>" />
    </p>
  
  <p><button type="submit" class="button">Enregistrer</button></p>
</form>
