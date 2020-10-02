<?php
/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

define('ROOT', './');
include_once(ROOT.'common/common.php');
if(!$runPlugin || $runPlugin->getConfigVal('activate') < 1) $core->error404();
elseif($runPlugin->getPublicFile()){
	include($runPlugin->getPublicFile());
	include($runPlugin->getPublicTemplate());
}
