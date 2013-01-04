<?php

class ShareButtonMail extends ShareButton {

	// AssetsManager compliant path to assets
	public function getAssets() {
		return array();
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 */
	public function getShareBox() {
		return F::app()->renderView( 'ShareButtonMail', 'Button' );
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
