<?php include_once(ROOT.'admin/header.php') ?>
<?php if($data['faqMode'] == 'list'){ ?>
<?php show::msg($data['faqMsg'], $data['faqMsgType']); ?>
<ul class="tabs_style">
  <li><a class="button" href="index.php?p=faq&action=edit">Ajouter</a></li>
</ul>
<table>
	<tr>
		<th>question</th>
		<th></th>
	</tr>
	<?php foreach($data['faqList'] as $faqEntry){ ?>
	<tr>
		<td><?php echo $faqEntry['question']; ?></td>
		<td><a class="button" href="index.php?p=faq&action=edit&id=<?php echo $faqEntry['id']; ?>">editer</a> <a class="button alert" href="index.php?p=faq&action=del&id=<?php echo $faqEntry['id']; ?>&token=<?php echo $data['token']; ?>" onclick = "if(!confirm('Supprimer cette entrée ?')) return false;">supprimer</a></th>
	</tr>
	<?php } ?>
</table>
<?php } elseif($data['faqMode'] == 'edit'){ ?>
<form method="post" action="index.php?p=faq&action=save">
	<?php show::adminTokenField(); ?>
	<input type="hidden" name="id" value="<?php echo $data['faqId']; ?>" />
	<p><label>Question</label><br />
	<input type="text" name="question" value="<?php echo $data['faqQuestion']; ?>" /></p>
	<p><label>Réponse</label><br />
	<textarea name="answer" class="editor"><?php echo $data['faqAnswer']; ?></textarea>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php include_once(ROOT.'admin/footer.php') ?>