<!-- s:<?= __FILE__ ?> -->
<? if ( "" != $err ) : ?>
<p class='error'><?=$err?></p>
<? endif ?>
<form name="textregex" method="post" action="<?=$action?>">
<table border="0" cellspacing="4">
<tr>
	<td align="right"><?= wfMsgExt( 'textregex-select-subpage', array( 'parseinline' ) ) ?></td>
	<td align="left">
		<select name="wpBlockedRegexList"><option value=""><?=wfMsg('textregex-select-default')?></option>
<? if (!empty($subpages)) { 
		foreach ($subpages as $subpage) {
?>
		<option value="<?=$subpage?>"><?=$subpage?></option>
<?			
		}
	}
?>		
		</select>
	</td>
	<td align="right"><?= wfMsgExt( 'textregex-create-subpage', array( 'parseinline' ) ) ?></td>
	<td align="left"><input tabindex="1" name="wpBlockedRegexListName" value="" /></td>
	<td align="left">
		<input tabindex="4" name="wpTextRegexBlockedSubmit" type="submit" value="<?=wfMsgExt('textregex-select-regexlist', array( 'escapenoentities' ) )?>" />
	</td>
</tr>
</table>
<input type='hidden' name='wpEditToken' value="<?=$token?>" />
</form>
<br />
<!-- e:<?= __FILE__ ?> -->
