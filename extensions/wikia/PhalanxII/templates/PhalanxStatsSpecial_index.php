<?= $table ?>

<a href="<?= htmlspecialchars($editUrl) ?>" class="modify"><?= wfMsg('phalanx-link-modify') ?></a>

<fieldset>
	<legend><?= wfMsg('phalanx-stats-results') ?></legend>
<?= $statsPager ?>
</fieldset>
