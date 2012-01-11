<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for vide description pages
 *
 * @ingroup Media
 */
class WikiaVideoPage extends ImagePage {
	
	protected static $videoWidth = 400;

	function openShowImage(){
		global $wgOut;
		$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$this->img->getEmbedCode(self::$videoWidth).'</div>' );
	}
}
