<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages
 *
 * @ingroup Media
 */
class WikiaVideoPage extends ImagePage {
	
	protected static $videoWidth = 660;

	function openShowImage(){
		global $wgOut, $wgTitle;
		$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$this->img->getEmbedCode($wgTitle->getArticleId(), self::$videoWidth).'</div>' );
	}
}
