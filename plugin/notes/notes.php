<?php
defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function notesInstall(){
    $notes = array(array(
        'id' => 0,
        'content' => 'Notez vos idées ici...',
    ));
    util::writeJsonFile(DATA_PLUGIN.'notes/notes.json', $notes);
}

## Hooks

function noteEndAdminBody(){
    global $administrator;
    $plugin = pluginsManager::getInstance()->getPlugin('seo');
    $temp = '<a class="button" href="javascript:" id="notes_btn"></a>';
    $temp.= '<div id="notes_window"><div id="notes_content" contenteditable="true"></div></div>';
    echo $temp;
}

## Ajax

if(isset($_GET['list']) && isset($_SESSION['admin'])){
    $data = util::readJsonFile(DATA_PLUGIN.'notes/notes.json');
    echo $data[0]['content'];
    die();
}

if(isset($_GET['save']) && isset($_SESSION['admin'])){
    $notes = array(array(
        'id' => 0,
        'content' => $_POST['content'],
    ));
    util::writeJsonFile(DATA_PLUGIN.'notes/notes.json', $notes);
}
?>