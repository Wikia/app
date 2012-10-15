<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<form method="get" action="<?=$action?>">
<fieldset>
<legend><?=wfMsg('multiwikifindpagenames')?></legend>
<?=wfMsg('multiwikienterpagename')?> <input name="target" value="<?=htmlspecialchars($mPage)?>" size="40">&#160;&#160;
<input type="submit" value="<?=wfMsg('qbfind')?>">
</fieldset>
</form>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
