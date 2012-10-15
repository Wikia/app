<?php

class ShareButtonGooglePlus extends ShareButton {

	public function __construct(WikiaApp $app) {
		parent::__construct($app);
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

		$html .= F::build('JSSnippets')->addToStack(
			array(),
			array(
				'$.loadGooglePlusAPI'
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
