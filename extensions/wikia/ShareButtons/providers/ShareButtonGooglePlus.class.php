<?php

class ShareButtonGooglePlus extends ShareButton {

	/**
	 * AssetsManager compliant path to assets
	 * @var array
	 */
	protected static $assets = array( '//extensions/wikia/ShareButtons/js/ShareButtonGooglePlus.js' );

	/**
	 * Return HTML rendering share box (with votes count)
	 *
	 * @see http://www.google.com/intl/en/webmasters/+1/button/index.html
	 * @return string
	 */
	public function getShareBox() {
		$html = Xml::element('div', array(
			'class' => 'g-plusone',
			'data-size' => 'tall',
			'data-href' => $this->getUrl(),
		), ' ');

		return $html;
	}
}
