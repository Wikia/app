<?php

class ImageDrop {

	public function onBeforePageDisplay( $out, $skin ) {
		wfProfileIn(__METHOD__);

		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
		$scssPackage = 'imagedrop_scss';
		$jsPackage = 'imagedrop_js';

		foreach ( $assetsManager->getURL( $scssPackage ) as $url ) {
			$out->addStyle( $url );
		}

		foreach ( $assetsManager->getURL( $jsPackage ) as $url ) {
			$out->addScript( "<script src=\"{$url}\"></script>" );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
