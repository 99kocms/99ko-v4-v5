<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');
?>

<form method="post" action="index.php?p=pluginsmanager&action=save" id="pluginsmanagerForm">
	<?php show::adminTokenField(); ?>
	<table>
	  <thead>
		<tr>
			<th>Nom</th>
			<th>Priorité</th>
			<th>Activer</th>
		</tr>
	  </thead>
	  <tbody>			  	
		<?php foreach($pluginsManager->getPlugins() as $plugin){ ?>
		<tr>
			<td>
				<?= $plugin->getInfoVal('name') ?>
				<?php if($plugin->getInfoVal('version') != 'none'){ ?> (version <?= $plugin->getInfoVal('version') ?>)<?php } ?>
				<?php if($plugin->getConfigVal('activate') && !$plugin->isInstalled()){ ?>&nbsp;&nbsp;<a class="button" href="index.php?p=pluginsmanager&action=maintenance&plugin=<?= $plugin->getName() ?>&token=<?= administrator::getToken() ?>">Maintenance requise</a><?php } ?>
				<div class="description">
					<?= $plugin->getInfoVal('description') ?>
				</div>
			</td>
			<td>
				<select name="priority[<?= $plugin->getName() ?>]" onchange="document.getElementById('pluginsmanagerForm').submit();">
					<?php foreach($priority as $k=>$v){ ?>
					<option <?php if($plugin->getconfigVal('priority') == $v){ ?>selected<?php } ?> value="<?= $v ?>"><?= $v ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<?php if(!$plugin->isRequired()){ ?>
				<input onchange="document.getElementById('pluginsmanagerForm').submit();" id="activate[<?= $plugin->getName() ?>]" type="checkbox" name="activate[<?= $plugin->getName() ?>]" <?php if($plugin->getConfigVal('activate')){ ?>checked<?php } ?> />
				<?php } else{ ?>
				<input style="display:none;" id="activate[<?= $plugin->getName() ?>]" type="checkbox" name="activate[<?= $plugin->getName() ?>]" checked />
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	  </tbody>					
	</table>
</form>

<?php include_once(ROOT.'admin/footer.php'); ?>
