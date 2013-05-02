<?php

/**
 * This class overrides MW's ImagePage.  It's used as a base class for all
 * customizations to file pages (both image and video) and in all skins.
 *
 * @ingroup Media
 * @author Hyun
 * @author Liz Lee
 * @author Garth Webb
 * @author Saipetch
 */
class FilePageFlat extends WikiaFilePage {

	/**
	 * Display info about the video below the video player
	 */
	protected function getVideoInfoLine( $file ) {
		wfProfileIn( __METHOD__ );

		$detailUrl = $file->getProviderDetailUrl();
		$provider = $file->getProviderName();
		if ( !empty($provider) ) {
			$providerName = explode( '/', $provider );
			$provider = array_pop( $providerName );
		}
		$providerUrl = $file->getProviderHomeUrl();

		$link = '<a href="' . $detailUrl . '" class="external" target="_blank">' . $this->mTitle->getText() . '</a>';
		$providerLink = '<a href="' . $providerUrl . '" class="external" target="_blank">' . $provider . '</a>';
		$cation = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerLink )  . '</div>';

		wfProfileOut( __METHOD__ );

		return $cation;
	}

}