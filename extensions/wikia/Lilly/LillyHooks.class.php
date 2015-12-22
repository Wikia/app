<?php

class LillyHooks {
	public static function onLinkerMakeExternalLink( &$url, &$text, &$link, &$attribs ) {
		self::processLink( $url, $text );

		return true;
	}

	public static function onLinkEnd( $dummy, Title $target, array $options, &$html, array &$attribs, &$ret ) {
		if ( $target->isExternal() ) {
			self::processLink( $attribs['href'], $html );
		}

		return true;
	}

	private static function processLink( $targetUrl, $linkText ) {
		global $wgTitle;

		$lillyValidator = new LillyValidator();

		if ( !$lillyValidator->validateLinkText( $linkText ) ) {
			return;
		}

		if ( !$lillyValidator->validateTitle( $wgTitle ) ) {
			return;
		}

		$lilly = new Lilly();
		$lilly->postLink( $wgTitle->getFullURL(), $targetUrl );
	}
}
