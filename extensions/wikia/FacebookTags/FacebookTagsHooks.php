<?php

class FacebookTagsHooks {
	public static function onParserFirstCallInit( Parser $parser ): bool {
		foreach ( FacebookTagConstants::SUPPORTED_TAGS as $parserTagName ) {
			$colonPosition = strpos( $parserTagName, ':' );
			$htmlTagName = substr( $parserTagName, $colonPosition + 1 );

			$parser->setHook( $parserTagName, new FacebookTagParser( $htmlTagName ) );
		}

		return true;
	}
}
