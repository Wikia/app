<? if ( isset( $table ) ) : ?>
<?= $table ?>
<? endif ?>

<? if ( isset( $editUrl ) ): ?>
<a href="<?= htmlspecialchars($editUrl) ?>" class="modify"><?= wfMsg('phalanx-link-modify') ?></a>
<? endif ?>

<? if ( isset( $statsPager ) ) : ?>
<fieldset>
	<legend><?= wfMsg('phalanx-stats-results') ?></legend>
<?= $statsPager ?>
</fieldset>
<? endif ?>
