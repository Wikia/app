<?php

/**
 * Extension allows customising the site logo via the MediaWiki namespace
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionFunctions[] = 'efLogo';
	$wgExtensionCredits['other'][] = array( 'name' => 'Logo', 'author' => 'Rob Church' );
	
	/** Whether or not to auto-scale the image to the required size */
	$wgLogoAutoScale = $wgUseImageResize;
	
	function efLogo() {
		global $wgLogo, $wgLogoAutoScale;
		$msg = wfMsgForContent( 'logo' );
		if( $msg != '&lt;logo&gt;' ) {
			$title = Title::newFromText( wfMsgForContent( 'logo' ) );
			if( is_object( $title ) ) {
				if( $title->getNamespace() != NS_IMAGE )
					$title = Title::makeTitle( NS_IMAGE, $title->getText() );
				$logo = Image::newFromTitle( $title );
				if( $logo->exists() )
					$wgLogo = $wgLogoAutoScale ? $logo->createThumb( 135 ) : $logo->getUrl();
			}
		}
	}

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}


