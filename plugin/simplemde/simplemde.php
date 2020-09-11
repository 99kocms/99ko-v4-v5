<?php

defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function simplemdeInstall() {
    
}

## Hooks

function simplemdeAdminHead() {
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">'
    . '<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>';
}

function simplemdeEndAdminBody() {
    echo '<script>
        $("textarea.editor").each(function () {
            var simplemde = new SimpleMDE({
                element: this,
            });
            simplemde.render();
        });</script>';
}

function simplemdeBlogBeforeSaveContent($content) {
    require_once PLUGINS . '/simplemde/libs/parsedown.php';
    require_once PLUGINS . '/simplemde/libs/parsedownextra.php';
    $parser = new ParsedownExtra();
    return $parser->parse($content);
}

function simplemdeBlogBeforeEditContent($content) {
    require_once PLUGINS . '/simplemde/libs/converter.php';
    require_once PLUGINS . '/simplemde/libs/converterextra.php';
    require_once PLUGINS . '/simplemde/libs/parser.php';
    $converter = new Markdownify\ConverterExtra();
    return $converter->parseString($content);
}

## Code relatif au plugin
?>