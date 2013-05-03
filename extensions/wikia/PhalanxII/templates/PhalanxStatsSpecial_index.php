<?= $table ?>

<? if ( isset( $editUrl ) ): ?>
<a href="<?= htmlspecialchars($editUrl) ?>" class="modify"><?= wfMsg('phalanx-link-modify') ?></a>
<? endif ?>

<fieldset>
	<legend><?= wfMsg('phalanx-stats-results') ?></legend>
<?= $statsPager ?>
</fieldset>
