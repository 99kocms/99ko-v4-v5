<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php show::siteLang(); ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>404</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
        <style type="text/css">
            body{
                font-family: 'Arial', sans-serif;
                font-size: 18px;
                color: #333;
                background: #fff;
                text-align: center;
                padding: 60px;
            }
            a{
                color: #333;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <p><?php echo $this->lang("The requested page does not exist.");?></p>
        <p><a href="<?php echo $this->getConfigVal('siteUrl'); ?>"><< Retour au site</a></p>
    </body>
</html>