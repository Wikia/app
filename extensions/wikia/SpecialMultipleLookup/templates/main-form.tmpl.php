<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<p class='error'><?=$error?></p>
<form method="get" action="<?=$action?>">
<?=wfMsg('multilookupselectuser')?> <input name="target" value="<?=htmlspecialchars($username)?>"/>&#160;&#160;
<input type="submit" value="<?=wfMsg('multilookupgo')?>">
</form>
<? if ( $username == "" ) { ?>
<br/><?=wfMsg('multilookupnotspecify')?>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
