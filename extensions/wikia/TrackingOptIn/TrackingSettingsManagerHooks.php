<?php

class TrackingSettingsManagerHooks {

	const PRIVACY_POLICY = 'Privacy Policy';

	public static function onOutputPageAfterParserOutput(
		OutputPage $out, ParserOutput $parserOutput
	) {

		if ( Action::getActionName( $out ) === 'view' &&
			 ( $out->getTitle()->getPrefixedText() === static::PRIVACY_POLICY ||
			   in_array( 'en:' . static::PRIVACY_POLICY, $parserOutput->getLanguageLinks() ) ) ) {
			$out->addModules( 'ext.wikia.trackingSettingsManager' );
		}
	}
}
