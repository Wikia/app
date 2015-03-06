<?
	$providerLink = '<a href="' . $providerUrl . '" target="_blank">' . $provider . '</a>';
	$providerPhrase = wfMessage( 'video-page-from-provider' )->rawParams( $providerLink )->escaped();
	if ( $expireDate ) {
		$providerPhrase .= "<span class='expire-date'>$expireDate</span>";
	}
?>

<div class="video-page-caption">
	<div class="inner">
		<p class="video-provider"><?= $providerPhrase ?></p>
		<? if ( !empty( $viewCount ) ): ?>
			<p class="video-views"><?= wfMessage( 'video-page-views' )->numParams( $viewCount )->parse() ?></p>
		<? endif; ?>
		<? if ( $regionalRestrictions ) : ?>
			<p class="regional-restriction hidden" id="restricted-content-viewable" data-regional-restrictions="<?= htmlspecialchars( strtolower( $regionalRestrictions ) ) ?>">
				<?= wfMessage('video-page-regional-restrictions-viewable')->plain() ?>
			</p>
			<p class="regional-restriction hidden" id="restricted-content-unviewable">
				<?=  wfMessage('video-page-regional-restrictions-unviewable')->plain() ?>
			</p>
		<? endif; ?>
	</div>
</div>
