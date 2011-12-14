<place <?php

	$aTmp = array();
	if ( $oEmptyPlaceModel->getAlign() != $oPlaceModel->getAlign() ) {
		$aTmp[] = "align='" . $oPlaceModel->getAlign() . "'";
	}
	if ( $oEmptyPlaceModel->getWidth() != $oPlaceModel->getWidth() ) {
		$aTmp[] = "width='" . $oPlaceModel->getWidth() . "'";
	}
	if ( $oEmptyPlaceModel->getHeight() != $oPlaceModel->getHeight() ) {
		$aTmp[] = "height='" . $oPlaceModel->getHeight() . "'";
	}
	if ( $oEmptyPlaceModel->getLat() != $oPlaceModel->getLat() ) {
		$aTmp[] = "lat='" . $oPlaceModel->getLat() . "'";
	}
	if ( $oEmptyPlaceModel->getLon() != $oPlaceModel->getLon() ) {
		$aTmp[] = "lon='" . $oPlaceModel->getLon() . "'";
	}
	if ( $oEmptyPlaceModel->getZoom() != $oPlaceModel->getZoom() ) {
		$aTmp[] = "zoom='" . $oPlaceModel->getZoom() . "'";
	}
	echo implode( ' ', $aTmp );
?> />