<label><?= wfMessage('yourbirthdate')->escaped() ?></label>
<?
$birthyearTemplate = '<select name="birthyear" ><option value="-1">'.wfMessage('userlogin-choose-year')->escaped().'</option>';
for($i=2011;$i>1900;$i--) {
	$selected = $birthyear == $i ? ' selected="selected"' : '';
	$birthyearTemplate .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
}
$birthyearTemplate .= '</select>';
if (!$isEn) echo $birthyearTemplate;
?>
<select name="birthmonth" >
	<option value="-1"><?= wfMessage('userlogin-choose-month')->escaped() ?></option>
	<? for($i=1;$i<=12;$i++) { ?>
		<option value="<?=$i?>" <?= $birthmonth == $i ? 'selected' : '' ?>><?=$i?></option>
	<? } ?>
</select>
<select name="birthday" >
	<option value="-1"><?= wfMessage('userlogin-choose-day')->escaped() ?></option>
	<? for($i=1;$i<=31;$i++) { ?>
		<option value="<?=$i?>" <?= $birthday == $i ? 'selected' : '' ?>><?=$i?></option>
	<? } ?>
</select>
<?= $isEn ? $birthyearTemplate : '' ?>