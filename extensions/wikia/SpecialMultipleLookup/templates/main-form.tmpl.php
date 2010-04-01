<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-FORM -->
<p class='error'><?=$error?></p>
<form method="get" action="<?=$action?>">
<?=wfMsg('multilookupselectuser')?> <input name="target" value="<?=htmlspecialchars($username)?>"/>&#160;&#160;
<input type="submit" value="<?=wfMsg('multilookupgo')?>">
</form>
<? if ( empty($username) ) { ?>
<br/><?=wfMsg('multilookupnotspecify')?>
<? } ?>
<!-- END OF MAIN-FORM -->
<!-- e:<?= __FILE__ ?> -->
