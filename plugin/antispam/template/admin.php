<?php
defined('ROOT') OR exit('No direct script access allowed');

include_once(ROOT . 'admin/header.php');
?>
<script>
    $(document).ready(function () {
        if ($('#radioRecaptcha').prop('checked')) {
            $('#useRecaptcha').show();
        } else {
            $('#useRecaptcha').hide();
            $('#useRecaptcha :input').prop('disabled', true);
        }
        $('input[type="radio"]').click(function () {
            if ($('#radioRecaptcha').prop('checked')) {
                $('#useRecaptcha').show();
                $('#useRecaptcha :input').prop('disabled', false);
            } else {
                $('#useRecaptcha').hide();
                $('#useRecaptcha :input').prop('disabled', true);
            }
        });
    });
</script>
<form method="post" action="index.php?p=antispam&action=saveconf">
    <?php show::adminTokenField(); ?>
    <p>
        <input <?php if ($runPlugin->getConfigVal('type') === 'useText') { ?>checked<?php } ?> type="radio" name="captcha" value="useText" id="radioText"/> Utiliser un captcha texte
    </p>
    <p>
        <input <?php if ($runPlugin->getConfigVal('type') === 'useRecaptcha') { ?>checked<?php } ?> type="radio" name="captcha" id="radioRecaptcha" value="useRecaptcha" /> Utiliser ReCaptcha de Google
    </p>
    <div id="useRecaptcha">
        <p>
            <label>Clé du site (clé publique)</label><br>
            <input type="text" required="required" name="recaptchaPublicKey" value="<?php echo $runPlugin->getConfigVal('recaptchaPublicKey'); ?>" />
        </p>
        <p
            <label>Clé secrète</label><br>
            <input type="text" required="required" name="recaptchaSecretKey" value="<?php echo $runPlugin->getConfigVal('recaptchaSecretKey'); ?>" />
        </p>
    </div>
    <p><button type="submit" class="button">Enregistrer</button></p>
</form>

<?php include_once(ROOT . 'admin/footer.php'); ?>