<?php

class ShareButtonTwitter extends ShareButton {

	public function __construct(WikiaApp $app) {
		parent::__construct($app);
	}

	// AssetsManager compliant path to assets
	public function getAssets() {
		return array( '//extensions/wikia/ShareButtons/js/ShareButtonTwitter.js' );
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 *
	 * @see http://twitter.com/goodies/tweetbutton
	 */
	public function getShareBox() {
		global $wgNoExternals;
		if (!empty($wgNoExternals)) {
			return '';
		}

		$html = Xml::element('a', array(
			'href' => 'https://twitter.com/share',
			'class' => 'twitter-share-button',
			'data-count' => 'vertical',
			'data-url' => $this->getUrl(),
		), 'Tweet');

		return $html;
	}

	/**
	 * Return HTML rendering share button
	 */
	public function getShareButton() {

	}

	/**
	 * Return HTML rendering share link
	 */
	public function getShareLink() {

	}
}
