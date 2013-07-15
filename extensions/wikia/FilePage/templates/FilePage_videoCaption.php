<?
	//$providerLink = '<a href="' . $detailUrl . '" target="_blank">' . $provider . '</a>';
	$providerLink = '<a href="' . $providerUrl . '" target="_blank">' . $provider . '</a>';
?>
<div class="video-page-caption">
	<p class="video-provider"><?= wfMessage( 'video-page-from-provider' )->rawParams( $providerLink )->escaped() ?></p>
	<p class="video-views"><?= wfMessage( 'video-page-views' )->numParams( $viewCount )->parse() ?></p>
	<? if( $expireDate ): ?>
		<p class="expire-date"><?= $expireDate ?></p>
	<? endif; ?>
</div>
