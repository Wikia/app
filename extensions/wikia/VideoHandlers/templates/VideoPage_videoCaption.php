<?
	$providerLink = '<a href="'.$detailUrl.'" target="_blank">'.$provider.'</a>';
?>
<p><?= wfMessage( 'video-page-from-provider' )->params( $providerLink )->text() ?></p>
<p><?= wfMessage( 'video-page-expires' )->params( $expireDate ) ?></p>
<p><?= wfMessage( 'video-page-views' )->params( $viewCount ) ?></p>