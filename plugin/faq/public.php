<?php
if(!defined('ROOT')) die();
$faq = new faq();
$data['faqList'] = array();
$faqMetaDescriptionTag = '';
foreach($faq->getEntries() as $k=>$faqEntry){
	$data['faqList'][$k]['id'] = $faqEntry->getId();
	$data['faqList'][$k]['question'] = $faqEntry->getQuestion();
	$data['faqList'][$k]['answer'] = $faqEntry->getAnswer();
	$faqMetaDescriptionTag.= $faqEntry->getQuestion().', ';
}
$faqMetaDescriptionTag = substr($faqMetaDescriptionTag, 0, -2);
if(mb_strlen($faqMetaDescriptionTag) > 150) $faqMetaDescriptionTag = mb_strcut($faqMetaDescriptionTag, 0, 150).'...';
$runPlugin->setMetaDescriptionTag($faqMetaDescriptionTag);
$data['faqNbEntries'] = $faq->countEntries();
?>
