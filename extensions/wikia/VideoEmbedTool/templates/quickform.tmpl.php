<form name="quickaddform" method="post" action="<?=$action?>">
<table>
<?php
if ('' == $name) {
?> 
<tr><td width="120">
<?= wfMsg( 'wva-name' ); ?>
</td>
<td>
<input type="text" id="wpWikiaVideoAddName" name="wpWikiaVideoAddName" size="50" />
</td>
</tr>
<?php
}
?>
<tr><td>
<?= wfMsg( 'wva-url' ); ?>
</td>
<td>
<input type="text" id="wpWikiaVideoAddUrl" name="wpWikiaVideoAddUrl" size="50" />
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="<?= wfMsg( 'wva-add' ); ?>" />
</td>
</tr>
</table>

<?php
if ('' != $name) {
?>
<input type="hidden" name="wpWikiaVideoAddPrefilled" value="<?= $name ?>" id="wpWikiaVideoAddPrefilled"  />
<?php
}
?>

</form>


