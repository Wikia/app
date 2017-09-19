<?php
/**
 * Class ExtImageSizeInfoFunctionsHooks
 * Hooks for ImageSizeInfoFunctionsHooks Extension
 */

class ExtImageSizeInfoFunctionsHooks {

	static public function parserFirstCallInit( Parser $parser ): bool {
		$parser->setFunctionHook( 'imgw', [ 'ExtImageSizeInfoFunctionsHooks', 'imageWidth' ] );
		$parser->setFunctionHook( 'imgh', [ 'ExtImageSizeInfoFunctionsHooks', 'imageHeight' ] );

		return true;
	}

	static public function imageWidth( $parser, $image = '' ) {
		$title = Title::newFromText( $image, NS_FILE );
		$file = wfFindFile( $title );

		return $file && $file->exists() ? $file->getWidth() : 0;
	}

	static public function imageHeight( $parser, $image = '' ) {
		$title = Title::newFromText( $image, NS_FILE );
		$file = wfFindFile( $title );

		return $file && $file->exists() ? $file->getHeight() : 0;
	}

}
