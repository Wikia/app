<div class="video-page-caption">
	<div class="inner">
		<p class="video-provider"><?= $providerPhrase ?></p>
		<? if ( $regionalRestrictions ) : ?>
			<p class="regional-restriction hidden" id="restricted-content-viewable" data-regional-restrictions="<?= Sanitizer::encodeAttribute( strtolower( $regionalRestrictions ) ); ?>">
				<?= wfMessage( 'video-page-regional-restrictions-viewable' )->escaped(); ?>
			</p>
			<p class="regional-restriction hidden" id="restricted-content-unviewable">
				<?=  wfMessage( 'video-page-regional-restrictions-unviewable' )->escaped(); ?>
			</p>
		<? endif; ?>
	</div>
</div>
