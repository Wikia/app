<?php

/**
 * This is for any wikia customizations to the mediawiki
 * file page. It's used on WikiaMobile and Monobook. Customizations
 * specific to Oasis should go in FilePageTabbed
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
	 *
	 * @todo Use a template for this
	 */
	public function getVideoInfoLine( $file ) {
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
		$caption = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerLink )  . '</div>';

		wfProfileOut( __METHOD__ );

		return $caption;
	}

}