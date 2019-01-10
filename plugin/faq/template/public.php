<?php include_once(ROOT.'theme/'.$core->getConfigVal('theme').'/header.php'); ?>
<div id="faqContent"><p><?php echo $data['faqNbEntries']; ?> questions dans la FAQ :</p></div>
<ul>
	<?php foreach($data['faqList'] as $faqEntry){ ?>
		<li><a href="javascript:faqShowEntry('faqEntry<?php echo $faqEntry['id']; ?>');"><?php echo $faqEntry['question']; ?></a></li>
	<?php } ?>
</ul>
<?php foreach($data['faqList'] as $faqEntry){ ?>
<div class="faqEntry" id="faqEntry<?php echo $faqEntry['id']; ?>">
	<h2><?php echo $faqEntry['question']; ?></h2>
	<?php echo $faqEntry['answer']; ?>
</div>
<?php } ?>
<?php include_once(ROOT.'theme/'.$core->getConfigVal('theme').'/footer.php'); ?>