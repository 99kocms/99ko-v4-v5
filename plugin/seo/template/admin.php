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
	<h3>Liens sur les réseaux sociaux</h3>
	<p>
      <label>Facebook</label><br>
      <input placeholder="" type="text" name="facebook" value="<?php echo $runPlugin->getConfigVal('facebook'); ?>" />
  </p>
	<p>
      <label>Twitter</label><br>
      <input placeholder="" type="text" name="twitter" value="<?php echo $runPlugin->getConfigVal('twitter'); ?>" />
  </p>
	<p>
      <label>YouTube</label><br>
      <input placeholder="" type="text" name="youtube" value="<?php echo $runPlugin->getConfigVal('youtube'); ?>" />
  </p>
	<p>
      <label>Instagram</label><br>
      <input placeholder="" type="text" name="instagram" value="<?php echo $runPlugin->getConfigVal('instagram'); ?>" />
  </p>
	<p>
      <label>Pinterest</label><br>
      <input placeholder="" type="text" name="pinterest" value="<?php echo $runPlugin->getConfigVal('pinterest'); ?>" />
  </p>
	<p>
      <label>Linkedin</label><br>
      <input placeholder="" type="text" name="linkedin" value="<?php echo $runPlugin->getConfigVal('linkedin'); ?>" />
  </p>
	<p>
      <label>Viadeo</label><br>
      <input placeholder="" type="text" name="viadeo" value="<?php echo $runPlugin->getConfigVal('viadeo'); ?>" />
  </p>
	<p>
      <label>GitHub</label><br>
      <input placeholder="" type="text" name="github" value="<?php echo $runPlugin->getConfigVal('github'); ?>" />
  </p>
	<p>
      <button type="submit" class="button">Enregistrer</button>
  </p>
</form>

<?php include_once(ROOT.'admin/footer.php'); ?>