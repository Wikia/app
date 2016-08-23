<?= $table ?>

<a href="<?= htmlspecialchars($editUrl) ?>" class="modify"><?= wfMsg('phalanx-link-modify') ?></a> &#183;
<a href="#" class="unblock" data-id="<?= Sanitizer::encodeAttribute( $blockId ); ?>"><?= $wg->Lang->lc( wfMessage( 'phalanx-link-unblock' )->escaped() ); ?></a>

<fieldset>
	<legend><?= wfMsg('phalanx-stats-results') ?></legend>
<?= $statsPager ?>
</fieldset>
