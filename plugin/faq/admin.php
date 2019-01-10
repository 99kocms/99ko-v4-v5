<?php
if(!defined('ROOT')) die();
$data['faqMode'] = '';
$data['faqMsg'] = '';
$data['faqMsgType'] = '';
$faq = new faq();
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
switch($action){
	case 'savefaqconfig':
		$runPlugin->setConfigVal('orderMode', intval($_POST['faqOrderMode']));
		$runPlugin->setConfigVal('label', trim($_POST['faqLabel']));
		$pluginsManager->savePluginConfig($runPlugin);
		header('location:index.php?p=faq');
		die();
		break;
	case 'save':
		if($_POST['id'] != '') $faqEntry = $faq->getEntry($_POST['id']);
		else $faqEntry = new faqEntry();
		$faqEntry->setQuestion($_POST['question']);
		$faqEntry->setAnswer($_POST['answer']);
		if($faq->addEntry($faqEntry)){
			header('location:index.php?p=faq');
			die();
		}
		else{
			$data['faqMsg'] = "Erreur d'enregistrement";
			$data['faqMsgType'] = 'error';
		}
		break;
	case 'edit':
		$faqEntry = (isset($_GET['id'])) ? $faq->getEntry($_GET['id']) : new faqEntry();
		$data['faqMode'] = 'edit';
		$data['faqId'] = $faqEntry->getId();
		$data['faqQuestion'] = $faqEntry->getQuestion();
		$data['faqAnswer'] = $faqEntry->getAnswer();
		break;
	case 'del':
		$faq->delEntry($_GET['id']);
		header('location:index.php?p=faq');
		die();
	default:
		$data['faqMode'] = 'list';
		$data['faqLabel'] = $runPlugin->getConfigVal('label');
		$data['faqOrderModeSelected'] = $runPlugin->getConfigVal('orderMode')-1;
		$data['faqList'] = array();
		foreach($faq->getEntries() as $k=>$faqEntry){
			$data['faqList'][$k]['id'] = $faqEntry->getId();
			$data['faqList'][$k]['question'] = $faqEntry->getQuestion();
			$data['faqList'][$k]['answer'] = $faqEntry->getAnswer();
		}
}
?>
