<?php

class ShareButtonGooglePlus extends ShareButton {

	public function __construct(WikiaApp $app) {
		parent::__construct($app);
	}

	// AssetsManager compliant path to assets
	public function getAssets() {
		return array( '//extensions/wikia/ShareButtons/js/ShareButtonGooglePlus.js' );
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 *
	 * @see http://www.google.com/intl/en/webmasters/+1/button/index.html
	 */
	public function getShareBox() {
		$html = Xml::element('div', array(
			'class' => 'g-plusone',
			'data-size' => 'tall',
			'data-href' => $this->getUrl(),
		), ' ');

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
