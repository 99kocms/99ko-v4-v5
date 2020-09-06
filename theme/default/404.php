<?php defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES.$core->getConfigVal('theme').'/header.php');
?>

        <p>La page demandée est introuvable</p>
        <p><a href="<?php echo $this->getConfigVal('siteUrl'); ?>"><< Retour au site</a></p>
<?php include_once(THEMES.$core->getConfigVal('theme').'/footer.php'); ?>