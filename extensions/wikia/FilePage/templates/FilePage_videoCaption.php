<?
	//$providerLink = '<a href="' . $detailUrl . '" target="_blank">' . $provider . '</a>';
	$providerLink = '<a href="' . $providerUrl . '" target="_blank">' . $provider . '</a>';
?>
<div class="video-page-caption">
	<p class="video-views"><?= wfMessage( 'video-page-views' )->numParams( $viewCount )->parse() ?></p>
	<p><?= wfMessage( 'video-page-from-provider' )->rawParams( $providerLink )->escaped() ?></p>
	<? if( $expireDate ): ?>
		<p class="video-provider"><?= $expireDate ?></p>
	<? endif; ?>
</div>
