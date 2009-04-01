<!-- s:<?= __FILE__ ?> -->
<? if ( "" != $err ) : ?>
<p class='error'><?=$err?></p>
<? endif ?>
<form name="textregex" method="post" action="<?=$action?>">
<table border="0">
<tr>
	<td align="right"><?= wfMsgExt( 'textregex-regex-block', array( 'parseinline' ) ) ?></td>
	<td align="left"><input tabindex="1" name="wpBlockedRegex" value="<?=$blockedRegex?>" /></td>
</tr>
<tr>
	<td align="right">&#160;</td>
	<td align="left">
		<input tabindex="4" name="wpTextRegexBlockedSubmit" type="submit" value="<?=wfMsgExt('textregex-submit-regex', array( 'escapenoentities' ) )?>" />
	</td>
</tr>
</table>
<input type='hidden' name='wpEditToken' value="<?=$token?>" />
<input type='hidden' name='wpSubpageRegex' value="<?=$subpage?>" />
</form>
<br />
<!-- e:<?= __FILE__ ?> -->
