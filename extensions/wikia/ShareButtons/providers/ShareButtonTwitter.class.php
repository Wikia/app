<?php

class ShareButtonTwitter extends ShareButton {

	public function __construct(WikiaApp $app) {
		parent::__construct($app);
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

		$html .= F::build('JSSnippets')->addToStack(
			array(),
			array(
				'$.loadTwitterAPI'
			)
		);

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
