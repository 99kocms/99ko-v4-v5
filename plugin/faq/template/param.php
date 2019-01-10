<form method="post" action="index.php?p=faq&action=savefaqconfig">
	<?php show::adminTokenField(); ?>
	<p>
		<label>Intitulé du lien</label><br />
		<input name="faqLabel" value="<?php echo $data['faqLabel']; ?>" type="text">
	</p>
	<p>
		<label>Préférence de tri</label><br />
		<select name="faqOrderMode" id="faqOrderMode">
			<option value="1">Ordre alphabétique</option>
			<option value="2">Entrées récentes en premier</option>
		</select>
	</p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<script>
document.getElementById('faqOrderMode').selectedIndex = <?php echo $data['faqOrderModeSelected']; ?>;
</script>