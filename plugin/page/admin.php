<?php
if(!defined('ROOT')) die();
$data['pageMode'] = '';
$data['pageMsg'] = '';
$data['pageMsgType'] = '';
switch(ACTION){
	case 'save':
		if($_POST['id'] != '') $pageItem = $page->create($_POST['id']);
		else $pageItem = new pageItem();
		$pageItem->setName($_POST['name']);
		$pageItem->setIsHomepage((isset($_POST['isHomepage'])) ? 1 : 0);
		$pageItem->setPosition($_POST['position']);
		$pageItem->setContent($_POST['content']);
		$pageItem->setFile($_POST['file']);
		$pageItem->setIsHidden((isset($_POST['isHidden'])) ? 1 : 0);
		$pageItem->setMainTitle($_POST['mainTitle']);
		$pageItem->setMetaDescriptionTag($_POST['metaDescriptionTag']);
		$page->save($pageItem);
		header('location:index.php?p=page');
		die();
		break;
	case 'edit':
		if(isset($_GET['id'])) $pageItem = $page->create($_GET['id']);
		else $pageItem = new pageItem();
		$data['pageId'] = $pageItem->getId();
		$data['pageName'] = $pageItem->getName();
		$data['pagePosition'] = $pageItem->getPosition();
		$data['pageIsHomepage'] = $pageItem->getIshomepage();
		$data['pageContent'] = $pageItem->getContent();
		$data['pageMode'] = 'edit';
		$data['pageIsHomepageChecked'] = ($pageItem->getIshomepage()) ? 'checked' : '';
		$data['pageFile'] = $pageItem->getFile();
		$data['pageIsHidden'] = $pageItem->getIsHidden();
		$data['pageFiles'] = $page->listFiles();
		$data['pageMainTitle'] = $pageItem->getMainTitle();
		$data['pageMetaDescriptionTag'] = $pageItem->getMetaDescriptionTag();
		$data['pageTheme'] = getConfVal('core', 'theme');
		break;
	case 'del':
		$pageItem = $page->create($_GET['id']);
		if($page->del($pageItem)){
			header('location:index.php?p=page');
			die();
		}
		else{
			$data['pageMsg'] = "Suppression impossible";
			$data['pageMsgType'] = 'error';
		}
	default:
		$pageItems = $page->getItems();
		$data['pageMode'] = 'list';
		if(!$page->createHomepage()){
			$data['pageMsg'] = "Aucune page d'accueil n'est définie";
			$data['pageMsgType'] = 'error';
		}
		$data['pageList'] = array();
		foreach($pageItems as $k=>$pageItem){
			$data['pageList'][$k]['id'] = $pageItem->getId();
			$data['pageList'][$k]['name'] = $pageItem->getName();
			$data['pageList'][$k]['position'] = $pageItem->getPosition();
			$data['pageList'][$k]['isHomepage'] = $pageItem->getIshomepage();
			$data['pageList'][$k]['content'] = $pageItem->getContent();
			$data['pageList'][$k]['isHidden'] = $pageItem->getIsHidden();
		}
}
?>

<?php include_once(ROOT.'admin/header.php') ?>
<?php if($data['pageMode'] == 'list'){ ?>
<?php showMsg($data['pageMsg'], $data['pageMsgType']); ?>
<p><a href="index.php?p=page&action=edit">Ajouter</a></p>
<table>
	<tr>
		<th>Nom</th>
		<th>Adresse</th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($data['pageList'] as $pageItem){ ?>
	<tr>
		<td><?php echo $pageItem['name']; ?></td>
		<td><?php echo $data['configSiteUrl']; ?>/index.php?p=page&id=<?php echo $pageItem['id']; ?></td>
		<td><?php if($pageItem['isHomepage']){ ?><img src="../plugin/page/house.png" alt="icon" title="Page d'accueil" /><?php } ?> <?php if($pageItem['isHidden']){ ?><img src="../plugin/page/bullet_orange.png" alt="icon" title="Cette page n'apparait pas dans le menu" /> <?php } ?></td>
		<td>
			<a href="index.php?p=page&action=edit&id=<?php echo $pageItem['id']; ?>">editer</a>
			<?php if(!$pageItem['isHomepage']){ ?> <a href="index.php?p=page&action=del&id=<?php echo $pageItem['id']; ?>&token=<?php echo $data['token']; ?>" onclick = "if(!confirm('Supprimer cette page ?')) return false;">supprimer</a><?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
<?php } elseif($data['pageMode'] == 'edit'){ ?>
<form method="post" action="index.php?p=page&action=save">
	<?php showAdminTokenField(); ?>
	<input type="hidden" name="id" value="<?php echo $data['pageId']; ?>" />
	<p><label>Nom</label><br />
	<input type="text" name="name" value="<?php echo $data['pageName']; ?>" /></p>
	<p><label>Titre de la page (facultatif)</label><br />
	<input type="text" name="mainTitle" value="<?php echo $data['pageMainTitle']; ?>" /></p>
	<p><label>Balise meta description (facultatif)</label><br />
	<input type="text" name="metaDescriptionTag" value="<?php echo $data['pageMetaDescriptionTag']; ?>" /></p>
	<p><label>Position du lien dans la navigation</label><br />
	<input type="text" name="position" value="<?php echo $data['pagePosition']; ?>" /></p>
	<p><input <?php echo $data['pageIsHomepageChecked']; ?> type="checkbox" name="isHomepage" /> Utiliser comme page d'accueil<br />
	<input <?php if($data['pageIsHidden']){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> Ne pas afficher de lien vers cette page dans le menu</p>
	<p><label>Contenu</label><br />
	<?php showAdminEditor('content', $data['pageContent'], '600', '400'); ?></p>
	<p><label>Inclure un fichier à la place du contenu</label><br />
		./theme/<?php echo $data['pageTheme']; ?>/ <select name="file">
			<option value="">--</option>
			<?php foreach($data['pageFiles'] as $file){ ?>
			<option <?php if($file == $data['pageFile']){ ?>selected<?php } ?> value="<?php echo $file; ?>"><?php echo $file; ?></option>
			<?php } ?>
		</select>
	</p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php include_once(ROOT.'admin/footer.php') ?>
