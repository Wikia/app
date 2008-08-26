<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<p class='error'><?=$error?></p>
<p><?=wfMsg('lookupcontribshelp')?></p>
<form method="get" action="<?=$action?>">
<?=wfMsg('lookupcontribsselectuser')?> <input name="target" value="<?=htmlspecialchars($username)?>"/>&#160;&#160;
<input type="submit" value="<?=wfMsg('lookupcontribsgo')?>">
</form>
<? if ( $username == "" ) { ?>
<br/><?=wfMsg('lookupcontribusernotspecify')?>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
