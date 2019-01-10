<?php
defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function tinymceInstall(){
}

## Hooks

function tinymceAdminHead(){
	echo "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
  <script>
  tinymce.init({
    selector: 'textarea.editor',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'save table contextmenu directionality emoticons template paste textcolor'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
    theme: 'modern'
  });
  </script>";
}

## Code relatif au plugin
?>