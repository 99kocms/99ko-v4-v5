<?php
defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function TrumbowygInstall(){
}

## Hooks

function TrumbowygEndAdminHead(){
	echo '<link rel="stylesheet" href="../plugin/Trumbowyg/ui/trumbowyg.min.css">';
}

function TrumbowygEndAdminBody(){
	echo '<script src="../plugin/Trumbowyg/trumbowyg.min.js"></script>';
	echo "<script>$('.editor').trumbowyg();</script>";
}

## Code relatif au plugin
?>