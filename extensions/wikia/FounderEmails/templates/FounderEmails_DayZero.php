<?php
function msg($key) {
	$text = null;

	if ( !empty( $language ) ) {
		// custom lang translation
		$text = wfMsgExt( $key, array( 'language' => $language ) );
	}

	if ( $text == null ) {
		$text = wfMsg( $key );
	}

	return $text;
}
?>
<table width="100%" style="font: 18px normal Helvetica,Arial;" bgcolor="2c85d7" cellpadding="20">
<tr>
<td>
<table align="center" bgcolor="ffffff" cellpadding="0" cellspacing="0" width="570">
<tr><td bgcolor="88c440" height="8" colspan="3" style="font-size:1px"></td></tr>
<tr>
<td bgcolor="88c440" width="8" style="font-size:1px"></td>
<td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<!-- content start -->

<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="170">
<img src="http://images2.wikia.nocookie.net/wikianewsletter/images/2/2b/Box.png" alt="Wikia Welcomes You">
</td>
<td align="right">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="40">
&nbsp;
</td>
</tr>
</table>
<h1 style="color:#fa5c1f;font-size:19px;font-weight:normal"><?= msg('founderemails-email-0-day-heading') ?></h1>
<h2 style="color:#fa5c1f;font-size:22px;font-weight:bold"><?= msg('founderemails-email-0-day-congratulations') ?></h2>
</td>
<td width="30">
&nbsp;
</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td colspan="3" height="20">&nbsp;</td>
</tr>
<tr>
<td width="30" height="40">&nbsp;</td>
<td style="color:#2c85d5;font-size:17px;font-weight:bold" valign="top"><?= msg('founderemails-email-0-day-tips-heading') ?></td>
<td width="30">&nbsp;</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="background:#f6f6f6;border-top:1px solid #ececec">
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td>
			<h2 style="color:#2c85d5;font-size:24px;font-weight:normal;margin:0"><?= msg('founderemails-email-0-day-addpages-heading') ?></h2>
			<span style="color:#919191;font-size:14px;line-height:20px">
				<?= msg('founderemails-email-0-day-addpages-content') ?>
			</span>
		</td>
		<td width="15">&nbsp;</td>
		<td valign="middle">
			<a href="$ADDAPAGEURL">
			<table cellpadding="0" cellspacing="0" background="http://images3.wikia.nocookie.net/wikianewsletter/images/9/9e/Founder_email_btn.png" width="101" height="39">
				<tr valign="middle" align="center">
					<td style="color:#fff;font-size:14px"><?= msg('founderemails-email-0-day-addpages-button') ?></td>
				</tr>
			</table>
			</a>
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;border-top:1px solid #ececec">
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td>
			<h2 style="color:#2c85d5;font-size:24px;font-weight:normal;margin:0"><?= msg('founderemails-email-0-day-addphotos-heading') ?></h2>
			<span style="color:#919191;font-size:14px;line-height:20px">
				<?= msg('founderemails-email-0-day-addphotos-content') ?>
			</span>
		</td>
		<td width="15">&nbsp;</td>
		<td valign="middle">
			<a href="$ADDAPHOTOURL">
			<table cellpadding="0" cellspacing="0" background="http://images3.wikia.nocookie.net/wikianewsletter/images/9/9e/Founder_email_btn.png" width="101" height="39">
				<tr valign="middle" align="center">
					<td style="color:#fff;font-size:14px"><?= msg('founderemails-email-0-day-addphotos-button') ?></td>
				</tr>
			</table>
			</a>
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="background:#f6f6f6;border-top:1px solid #ececec">
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td>
			<h2 style="color:#2c85d5;font-size:24px;font-weight:normal;margin:0"><?= msg('founderemails-email-0-day-customizetheme-heading') ?></h2>
			<span style="color:#919191;font-size:14px;line-height:20px">
				<?= msg('founderemails-email-0-day-customizetheme-content') ?>
			</span>
		</td>
		<td width="15">&nbsp;</td>
		<td valign="middle">
			<a href="$CUSTOMIZETHEMEURL">
			<table cellpadding="0" cellspacing="0" background="http://images3.wikia.nocookie.net/wikianewsletter/images/9/9e/Founder_email_btn.png" width="101" height="39">
				<tr valign="middle" align="center">
					<td style="color:#fff;font-size:14px"><?= msg('founderemails-email-0-day-customizetheme-button') ?></td>
				</tr>
			</table>
			</a>
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;border-top:1px solid #ececec">
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td colspan="2">
			<span style="color:#919191;font-size:14px;line-height:20px">
				<?= msg('founderemails-email-0-day-wikiahelps-text') ?>
			</span>
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td style="color:#919191;font-size:14px;line-height:20px">
			<?= msg('founderemails-email-0-day-wikiahelps-signature') ?>
		</td>
		<td valign="bottom" align="right">
			<img alt="Wikia" src="http://images3.wikia.nocookie.net/wikianewsletter/images/2/28/Wikialogo.png">
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" height="20">&nbsp;</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="background:#f6f6f6">
<tr>
<td height="18">&nbsp;</td>
</tr>
<tr>
<td align="center" style="font-size:11px;color:#aaa;line-height:16px">
<?= msg('founderemails-email-0-day-footer-line1') ?>
<br>
<?= msg('founderemails-email-0-day-footer-line2') ?>
<br>
<?= msg('founderemails-email-0-day-footer-line3') ?>
</td>
</tr>
<tr>
<td align="center" valign="middle" height="50">
<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>
</td>
</tr>
</table>

<!-- content end -->
</td>
</tr>
</table>
</td>
<td bgcolor="88c440" width="8" style="font-size:1px">&nbsp;</td>
</tr>
<tr><td bgcolor="88c440" height="8" colspan="3" style="font-size:1px">&nbsp;</td></tr>
</table>

</td>
</tr>
</table>