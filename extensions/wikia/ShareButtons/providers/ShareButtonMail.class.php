<?php

class ShareButtonMail extends ShareButton {
	/**
	 * Return HTML rendering share box (with votes count)
	 * @return string
	 */
	public function getShareBox() {
		return F::app()->renderView( 'ShareButtonMail', 'Button' );
	}
}
