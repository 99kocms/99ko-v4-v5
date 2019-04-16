<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>99ko</title>
	<?php foreach($data['linkTags'] as $file){ ?>
		<link href="<?php echo $file; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<meta name="robots" content="noindex" />
</head>
<body>
<div id="container">
	<div id="header">
		<h1>99Ko</h1>
	</div>
	<div id="login">
		<h2>Login</h2>
		<?php showMsg($data['msg'], 'error'); ?>
		<form method="post" action="index.php?action=login">
			<?php showAdminTokenField(); ?>
			<p><label>Mot de passe<br />
			<input type="password" name="adminPwd" id="adminPwd" /></p>
			<p><input type="submit" value="Valider" /></p>
		</form>
	</div>
	<div id="footer">
	</div>
</div>
<script type="text/javascript">
document.getElementById('adminPwd').focus()
</script>
</body>
</html>
