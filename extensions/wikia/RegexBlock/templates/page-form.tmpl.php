<!-- s:<?= __FILE__ ?> -->
<div style="float:left; clear:both; margin-left: auto; margin-right:auto">
<? if ( "" != $err ) { 
$out->setSubtitle( wfMsgHtml( 'formerror' ) ); ?>    
<h2 class="errorbox"><?=$err?></h2>
<? } elseif ($msg != "") { ?>
<h2 class="successbox"><?=$msg?></h2>
<? } ?>
</div>
<div style="clear:both; width:auto;"><?=wfMsg('regexblock_help')?></div>
<fieldset  style="width:90%; margin:auto;" align="center">
<legend><?=wfMsg('regexblock_block_user')?></legend>
<form name="regexblock" method="post" action="<?=$action?>">
<table border="0">
<tr>
<td align="right"><?=wfMsg('regexblock_ip_or_address')?>:</td>
<td align="left">
   <input tabindex="1" name="wpRegexBlockedAddress" id="wpRegexBlockedAddress" size="40" value="<?=$mRegexBlockedAddress?>" style="border: 1px solid #2F6FAB;" />
</td>
</tr>
<tr>
<td align="right"><?=ucfirst(wfMsg('regexblock_reason'))?></td>
<td align="left">
    <input tabindex="2" name="wpRegexBlockedReason" id="wpRegexBlockedReason" size="40" value="<?=$mRegexBlockedReason?>" style="border: 1px solid #2F6FAB;" />
</td>
</tr>
<tr>
<td align="right"><?=ucfirst(wfMsg('regexblock_expiry'))?></td>
<td align="left">
    <select name="wpRegexBlockedExpire" id="wpRegexBlockedExpire" tabindex="3" style="border: 1px solid #2F6FAB;">
<? foreach ($expiries as $k => $v) { ?>
    <option <?=($k == $mRegexBlockedExpire) ? "selected" : ""?> value="<?=$k?>"><?=$v?></option>
<? } ?>
    </select>
</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td align="left">
    <input type="checkbox" tabindex="4" name="wpRegexBlockedExact" id="wpRegexBlockedExact" value="1" <?= ($mRegexBlockedExact) ? "checked" : "" ?> />
    <label for="wpRegexBlockedExact"><?= wfMsg('regexblock_exact_match_form') ?></label>
</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td align="left">
    <input type="checkbox" tabindex="5" name="wpRegexBlockedCreation" id="wpRegexBlockedCreation" value="1" <?= ($mRegexBlockedCreation) ? "checked" : "" ?> />
    <label for="wpRegexBlockedCreation"><?=wfMsg('regexblock_block_creation_text')?></label>
</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td align="left">
    <input tabindex="6" name="wpRegexBlockedSubmit" type="submit" value="<?=wfMsg('regexblock_submit_block')?>" class="red_button" />
</td>
</tr>
</table>
<input type='hidden' name='wpEditToken' value="<?=$token?>" />
</form>
</fieldset>
<br />
<!-- e:<?= __FILE__ ?> -->
