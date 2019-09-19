<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="fr">
  <head>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="robots" content="noindex"><meta name="googlebot" content="noindex">
	<title>99ko - Mot de passe perdu</title>	
	<?php show::linkTags(); ?>
	<link rel="stylesheet" href="styles.css" media="all">
	<?php show::scriptTags(); ?>
	<script type="text/javascript" src="scripts.js"></script>
  </head>
  <body class="login">
		<?php show::msg($msg); ?>
  <div id="login">
	<h1>Changement de mot de passe</h1>
    <?php if($step == 'form'){ ?>
	<form method="post" action="index.php?action=lostpwd&step=send">   
	  <?php show::adminTokenField(); ?>
      <p>Entrez l'email administrateur et validez. Si cellui-ci est correct, vous recevrez un nouveau mot de passe qu'il faudra confirmer immédiatement via le lien de validation.</p>
	  <p>
      <label for="adminEmail">Email administrateur</label><br>
      <input style="display:none;" type="text" name="_email" value="" />
      <input type="email" id="adminEmail" name="adminEmail" required>
    </p>
		<input type="submit" class="button" value="Valider" />
		</p>
	</form>
    <?php } elseif($step == 'send'){ ?>
    <p>Un mot de passe vient d'être envoyé par email, voici les étapes permettant de valider son changement :</p>
    <ul>
        <li>Ne quittez pas cette page et ne la rechargez pas</li>
        <li>Ouvrez l'email reçu, toujours sans quitter cette page (dans un autre onglet)</li>
        <li>Cliquez sur le lien de validation</li>
        <li>Connectez-vous avec le nouveau mot de passe</li>
        <li>Vous pourrez changer le mot de passe dans la section configuration</li>
    </ul>
    <?php } elseif($step == 'confirm'){ ?>
    <p>Le mot de passe administrateur a bien été modifié. Vous pouvez maintenant vous connecter.</p>
    <p><a class="button" href="index.php">Me connecter</a></p>
    <?php } ?>
    <p class="just_using"><a target="_blank" href="https://github.com/99kocms/">Just using 99ko</a>
	  </p>
  </div>
  </body>
</html>