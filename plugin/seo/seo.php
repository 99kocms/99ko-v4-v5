<?php
defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function seoInstall(){
}

## Hooks

function seoEndFrontHead(){
    $plugin = pluginsManager::getInstance()->getPlugin('seo');
    $temp = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '".$plugin->getConfigVal('trackingId')."', 'auto');
  ga('send', 'pageview');

</script>";
    $temp.= '<meta name="google-site-verification" content="'.$plugin->getConfigVal('wt').'" />';
    $temp.= '<link href="'.$plugin->getConfigVal('gplus').'" rel="publisher" />';
    echo $temp;
}

function seoEndFrontBody(){
    $plugin = pluginsManager::getInstance()->getPlugin('seo');
    $gplus = $plugin->getConfigVal('gplus');
    $facebook = $plugin->getConfigVal('facebook');
    $twitter = $plugin->getConfigVal('twitter');
    $youtube = $plugin->getConfigVal('youtube');
    if($gplus.$facebook.$twitter != ''){
        echo '<div id="seo_social">';
        if($gplus != '') echo '<a target="_blank" href="'.$gplus.'">Google+</a>';
        if($facebook != '') echo '<a target="_blank" href="'.$facebook.'">Facebook</a>';
        if($twitter != '') echo '<a target="_blank" href="'.$twitter.'">Twitter</a>';
        if($youtube != '') echo '<a target="_blank" href="'.$youtube.'">YouTube</a>';
        echo '</div>';
    }
}
?>