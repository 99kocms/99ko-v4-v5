<?php
if(!defined('ROOT')) die();
$action = (isset($_GET['action'])) ? urldecode($_GET['action']) : '';
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
switch($action){
    case 'save':
        if($administrator->isAuthorized()){
            if(isset($_GET['fromparam'])){
                $runPlugin->setConfigVal('label', $_POST['label']);
                $runPlugin->setConfigVal('copy', $_POST['copy']);
                //$runPlugin->getConfigVal('content1');
                //$runPlugin->getConfigVal('content2');
            }
            else{
                $runPlugin->setConfigVal('content1', $_POST['content1']);
                $runPlugin->setConfigVal('content2', $_POST['content2']);
                //$runPlugin->getConfigVal('label');
                //$runPlugin->getConfigVal('copy');
            }
            if($pluginsManager->savePluginConfig($runPlugin)) $msg = "Les modifications ont été enregistrées";
            else $msg = "Une erreur est survenue";
            header('location:index.php?p=contact&msg='.urlencode($msg));
            die();
        }
        break;
    default;
        $emails = implode("\n", util::readJsonFile(DATA_PLUGIN.'contact/emails.json'));
        break;
}
?>