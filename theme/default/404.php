<?php defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES.$core->getConfigVal('theme').'/header.php');
?>

<div class="error404">
    <p>La page demandée est introuvable !</p>
    <p><a href="<?php echo $this->getConfigVal('siteUrl'); ?>">Aller à l'accueil</a></p>
</div>

<?php include_once(THEMES.$core->getConfigVal('theme').'/footer.php'); ?>