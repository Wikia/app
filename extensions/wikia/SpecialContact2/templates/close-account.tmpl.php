<?= wfMsgExt( 'specialcontact-intro-close-account', array( 'parse' ) ) ?>

<h2><?= wfMsg( 'specialcountact-form-header' ) ?></h2>

<form id="contactform" method="post" action="">
<input hidden="wpContactCategory" value="close-account" />

<p>
<label for="wpUserName"><?= wfMsg( 'specialcontact-username' ) ?></label>
<input name="wpUserName" value="<?= $encName ?>" />
</p>

<p>
<label for="wpEmail"><?= wfMsg( 'specialcontact-yourmail' ) ?></label>
<input name="wpEmail" value="<?= $encEmail ?>" />
</p>

<p>
<label for="wpReadHelp"><?= wfMsgExt( 'specialcontact-label-close-account-read-help', array( 'parseinline' ) ) ?></label>
<input type="checkbox" name="wpReadHelp" />
</p>

<p>
<label for="wpConfirm"><?= wfMsg( 'specialcontact-label-close-account-confirm' ) ?></label>
<input type="checkbox" name="wpConfirm" />
</p>
         
<?php if( !$isLoggedIn ) { ?>
        <table><tr> 
        <td style='width:200px'><input type='text' id='wpCaptchaWord' name='wpCaptchaWord' value='' /><br/>
                        <span class='captchDesc'><?= wfMsg('specialcontact-captchainfo') ?></span>
                        <input type='hidden' value='<?= $captchaIndex ?>' id='wpCaptchaId' name='wpCaptchaId'>
        </td>
        <td><img class='contactCaptch' height='50' src='<?= $captchaUrl ?>' /></td>
        </tr></table>
</p>
<?php } ?>

<input type="submit" value="<?= wfMsg( 'specialcontact-mail' ) ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
</form>

<p><?= wfMsgExt( 'specialcontact-noform-footer', array( 'parse' ) ) ?></p>
