<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<form method="post" action="index.php?p=seo&action=save">
  <?php show::adminTokenField(); ?>
  <h3>Google</h3>
  <p>
      <label>Identifiant de suivi Analytics</label><br>
      <input type="text" name="trackingId" value="<?php echo $runPlugin->getConfigVal('trackingId'); ?>" />
  </p>
  <p>
      <label>Meta google site verification</label><br>
      <input type="text" name="wt" value="<?php echo $runPlugin->getConfigVal('wt'); ?>" />
  </p>
	<p>
      <label>Page Google+</label><br>
      <input placeholder="" type="text" name="gplus" value="<?php echo $runPlugin->getConfigVal('gplus'); ?>" />
  </p>
  <p>
      <label>Chaîne YouTube</label><br>
      <input placeholder="" type="text" name="youtube" value="<?php echo $runPlugin->getConfigVal('youtube'); ?>" />
  </p>
	<h3>Facebook</h3>
	<p>
      <label>Page Facebook</label><br>
      <input placeholder="" type="text" name="facebook" value="<?php echo $runPlugin->getConfigVal('facebook'); ?>" />
  </p>
	<h3>Twitter</h3>
	<p>
      <label>Compte Twitter</label><br>
      <input placeholder="" type="text" name="twitter" value="<?php echo $runPlugin->getConfigVal('twitter'); ?>" />
  </p>
	<p>
      <button type="submit" class="button">Enregistrer</button>
  </p>
</form>

<?php include_once(ROOT.'admin/footer.php'); ?>