<!-- s:<?= __FILE__ ?> -->
<?php
$tabindex = 1;
if ( !empty($err) ) {
	print $err;
}
?>
<div id="SpecialContactIntroForm">
<?php print $intro; ?>
</div>
<hr/>
<form id="contactform" method="post" action="" enctype="multipart/form-data">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />

<?php if ( $isLoggedIn ) {
	echo wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock();
	echo wfMessage( 'specialcontact-mail-on-file',  $encEmail )->parseAsBlock();
} else {
?>
<p>
<label for="wpUserName"><?= wfMessage( 'specialcontact-username' )->escaped() ?></label>
<input name="wpUserName" value="<?= $encName ?>" />
</p>

<p>
<label for="wpEmail"><?= wfMessage( 'specialcontact-yourmail' )->escaped() ?></label>
<input name="wpEmail" value="<?= $encEmail ?>" />
</p>
<?php } ?>

<p class="contactformcaption"><?php echo wfMessage( 'specialcontact-problem' )->escaped(); ?></p>
<?php
	print "<input ". $eclass['wpContactSubject'] ." tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactSubject\" value=\"{$encProblem}\" size='60' />";
?>

<p class="contactformcaption"><?php echo wfMessage( 'specialcontact-problemdesc' )->escaped(); ?></p>
<?php
	print "<textarea ". $eclass['wpContactDesc'] ." tabindex='" . ($tabindex++) . "' name=\"wpContactDesc\" rows=\"10\" cols=\"60\">{$encProblemDesc}</textarea>";
?>

<p>
<label for="wpScreenshot1"><?= wfMessage( 'specialcontact-label-screenshot' )->escaped() ?></label>
<input id="wpScreenshot1" name="wpScreenshot[]" type="file" accept="image/*" multiple />
</p>

<?php	
if( !$isLoggedIn && (isset($captchaForm)) ) {
	echo "<div class='captcha'>" .
	wfMessage( 'specialcontact-captchatitle' )->escaped() .
	$captchaForm .
	wfMessage( 'specialcontact-captchainfo' )->escaped() .
	"</div>\n";
}
?>
<p><?php print "<input tabindex='" . ($tabindex++) . "' type='submit' value=\"". wfMessage( 'specialcontact-mail' )->escaped() ."\" />"; ?></p>

<?php
if( $isLoggedIn && $hasEmail ) {
	//is user, has email, but is verified?
	if( $hasEmailConf ) {
		//yes!
		print "<input tabindex='" . ($tabindex++) . "' type='checkbox' name=\"wgCC\" value=\"1\" />" . wfMessage( 'specialcontact-ccme' )->escaped();
	}
	else
	{
		//not
		print "<s><i>" . wfMessage( 'specialcontact-ccme' )->escaped() . "</i></s><br/> ". wfMessage( 'specialcontact-ccdisabled' )->parse() ."";
	}
}
?>

<?php #we prefil the browser info in from PHP var ?>
<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

<!-- e:<?= __FILE__ ?> -->
