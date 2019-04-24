<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<form method="post" action="index.php?p=contact&action=save">
    <?php show::adminTokenField(); ?>
    <p>
        <label>Contenu avant le formulaire</label><br>
        <textarea class="editor" name="content1"><?= $runPlugin->getConfigVal('content1') ?></textarea>
    </p>
    <p>
        <label>Contenu après le formulaire</label><br>
        <textarea class="editor" name="content2"><?= $runPlugin->getConfigVal('content2') ?></textarea>
    </p>
    <p><button type="submit" class="button">Enregistrer</button></p>
</form>

<?php include_once(ROOT.'admin/footer.php'); ?>
