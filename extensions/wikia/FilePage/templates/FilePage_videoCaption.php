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
		<p class="video-views"><?= wfMessage( 'video-page-views' )->numParams( $viewCount )->parse() ?></p>
		<? if ( $regionalRestrictions ) : ?>
			<p class="regional-restriction"><?= $regionalRestrictions ?></p>
		<? endif; ?>
	</div>
</div>
