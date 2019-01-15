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

define('VERSION', '4.4.1');
define('COMMON',  ROOT.'common/');
define('DATA', ROOT.'data/');
define('UPLOAD', ROOT.'data/upload/');
define('DATA_PLUGIN', ROOT.'data/plugin/');
define('THEMES', ROOT.'theme/');
define('PLUGINS', ROOT.'plugin/');
define('ADMIN_PATH', ROOT.'admin/');
define('NORMALIZE', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css');
define('JQUERY', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js');
if(file_exists(DATA.'key.php')) include(DATA.'key.php');
?>