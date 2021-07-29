<?php
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
if ($action === 'saveconf') {
    if ($administrator->isAuthorized()) {
        if ($_POST['captcha'] === 'useRecaptcha') {
            // Use ReCaptcha
            if (!isset($_POST['recaptchaPublicKey']) || !isset($_POST['recaptchaSecretKey']) ||
                    trim($_POST['recaptchaPublicKey']) == '' || trim($_POST['recaptchaSecretKey']) == '') {
                // Empty keys
                $msg = "Les clés de ReCaptcha ne peuvent pas être vides";
                $msgType = 'error';
                header('location:index.php?p=antispam&msg=' . urlencode($msg) . '&msgType=' . $msgType);
                die();
            }
            // Save ReCaptcha
            $runPlugin->setConfigVal('recaptchaPublicKey', trim($_POST['recaptchaPublicKey']));
            $runPlugin->setConfigVal('recaptchaSecretKey', trim($_POST['recaptchaSecretKey']));
        }
        // Save Type
        $runPlugin->setConfigVal('type', trim($_POST['captcha']));
        $pluginsManager->savePluginConfig($runPlugin);
        
        $msg = "Les modifications ont été enregistrées";
        $msgType = 'success';
        header('location:index.php?p=antispam&msg=' . urlencode($msg) . '&msgType=' . $msgType);
        die();
    }
}