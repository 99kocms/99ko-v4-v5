<?php
defined('ROOT') OR exit('No direct script access allowed');
$page = new page();
# Création, de la page
$id = (isset($_GET['id'])) ? $_GET['id'] : false;
if(!$id) $pageItem = $page->createHomepage();
elseif($pageItem = $page->create($id)){}
else $core->error404();
if($pageItem->targetIs() != 'page') $core->error404();
$action = (isset($_POST['unlock'])) ? 'unlock' : '';
switch($action){
    case 'unlock':
        // quelques contrôle et temps mort volontaire avant le send...
        sleep(2);
        if($_POST['_password'] == '' && $_SERVER['HTTP_REFERER'] == $runPlugin->getPublicUrl().util::strToUrl($pageItem->getName()).'-'.$pageItem->getId().'.html') $page->unlock($pageItem, $_POST['password']);
        $redirect = $runPlugin->getPublicUrl().util::strToUrl($pageItem->getName()).'-'.$pageItem->getId().'.html';
        header('location:'.$redirect);
        die();
        break;
    default:
        if($page->isUnlocked($pageItem)){
            # Gestion du titre
            if($runPlugin->getConfigVal('hideTitles')) $runPlugin->setMainTitle('');
            else $runPlugin->setMainTitle(($pageItem->getMainTitle() != '') ? $pageItem->getMainTitle() : $pageItem->getName());
            # Gestion des metas
            if($pageItem->getMetaTitleTag()) $runPlugin->setTitleTag($pageItem->getMetaTitleTag());
            else $runPlugin->setTitleTag($pageItem->getName());
            if($pageItem->getMetaDescriptionTag()) $runPlugin->setMetaDescriptionTag($pageItem->getMetaDescriptionTag());
            // template
            $pageFile = ($pageItem->getFile()) ? THEMES .$core->getConfigVal('theme').'/'.$pageItem->getFile() : false;
        }
        else{
            $runPlugin->setTitleTag('Accès restreint');
            $runPlugin->setMainTitle('Accès restreint');
        }
}
?>