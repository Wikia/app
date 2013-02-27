<?
	//$providerLink = '<a href="' . $detailUrl . '" target="_blank">' . $provider . '</a>';
	$providerLink = '<a href="' . $providerUrl . '" target="_blank">' . $provider . '</a>';
?>
<div class="video-page-caption">
	<p class="video-views"><?= wfMessage( 'video-page-views' )->params( $viewCount ) ?></p>
	<p><?= wfMessage( 'video-page-from-provider' )->params( $providerLink )->text() ?></p>
	<p><?= $expireDate ?></p>
</div>
