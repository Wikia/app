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
<form name="contactform" id="contactform" method="post" action="<?php echo $form_action; ?>">
<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-wikiname' ); ?></p>
<?php
	if( $unlockURL ) :
		print "<input ". $eclass['wpContactWikiName'] ." tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactWikiName\" value=\"{$wgServer}\" size='40' />";
	else :
		print "{$wgServer} <input type=\"hidden\" name=\"wpContactWikiName\" value=\"{$wgServer}\" />";
	endif;
?>

<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-username' ); ?></p>
<?php
	if( empty($user_readonly) ) :
		print "<input ". $eclass['wpName'] ."  tabindex='" . ($tabindex++) . "' type='text' name=\"wpName\" value=\"{$encName}\" size='40' />";
	else :
		print "{$encName} <input type=\"hidden\" name=\"wpName\" value=\"{$encName}\" />".
				" &nbsp;<span style=\"\" id='contact-not-me'><i><a href=\"{$logoutURL}\">(". wfMsg( 'specialcontact-notyou', $encName ) .")</a></i></span>";
	endif;
?>

<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-realname' ); ?></p>
<?php
	if( empty($name_readonly) ) :
		print "<input ". $eclass['wpContactRealName'] ." tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactRealName\" value=\"{$encRealName}\" size='40' />";
	else :
		print "{$encRealName} <input  type=\"hidden\" name=\"wpContactRealName\" value=\"{$encRealName}\" />";
	endif;
?>

<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-yourmail' ); ?></p>
<?php
	if( empty($mail_readonly) ) :
		print "<input ". $eclass['wpEmail'] ." tabindex='" . ($tabindex++) . "' type='text' name=\"wpEmail\" value=\"{$encEmail}\" size='40' />";
	else :
		print "{$encEmail} <input  type=\"hidden\" name=\"wpEmail\" value=\"{$encEmail}\" />";
	endif;
?>

<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-problem' ); ?></p>
<?php
	print "<input ". $eclass['wpContactSubject'] ." tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactSubject\" value=\"{$encProblem}\" size='60' />";
?>

<p class="contactformcaption"><?php echo wfMsg( 'specialcontact-problemdesc' ); ?></p>
<?php
	print "<textarea ". $eclass['wpContactDesc'] ." tabindex='" . ($tabindex++) . "' name=\"wpContactDesc\" rows=\"10\" cols=\"60\">{$encProblemDesc}</textarea>";
?>

<?php	
if( !$isLoggedIn ) {
	print '<p class="contactformcaption">'  . wfMsg( 'specialcontact-captchatitle' ) . "</p>\n";
	print "<table><tr>";
	print "<td style='width:200px;'><input ". $eclass['wpCaptchaWord'] ." type='text' id='wpCaptchaWord' name='wpCaptchaWord' value='' /><br/>
			<span class='captchDesc'>".wfMsg('specialcontact-captchainfo')."</span>
			<input type='hidden' value='". $captchaIndex ."' id='wpCaptchaId' name='wpCaptchaId'></td>\n";
	print "<td><img class='contactCaptch' height='50' src='". $captchaUrl ."' /></td>\n";
	print "</tr></table>\n";
	print "<br/>\n";
}
?>
<p><?php print "<input tabindex='" . ($tabindex++) . "' type='submit' value=\"". wfMsg( 'specialcontact-mail' ) ."\" />"; ?></p>

<?php
if( $isLoggedIn && $hasEmail ) {
	//is user, has email, but is verified?
	if( $hasEmailConf ) {
		//yes!
		print "<input tabindex='" . ($tabindex++) . "' type='checkbox' name=\"wgCC\" value=\"1\" />" . wfMsg('specialcontact-ccme');
	}
	else
	{
		//not
		print "<s><i>" . wfMsg('specialcontact-ccme') . "</i></s><br/> ". wfMsgExt('specialcontact-ccdisabled', array('parse') ) ."";
	}
}
?>

<?php #we prefil the browser info in from PHP var ?>
<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
</form>

<!-- e:<?= __FILE__ ?> -->
