<?php
/**
 * Class ExtImageSizeInfoFunctionsHooks
 * Hooks for ImageSizeInfoFunctionsHooks Extension
 */

class ExtImageSizeInfoFunctionsHooks {

	static public function parserFirstCallInit( Parser &$parser ) {
		$parser->setFunctionHook( 'imgw', array( 'ExtImageSizeInfoFunctionsHooks', 'imageWidth' ) );
		$parser->setFunctionHook( 'imgh', array( 'ExtImageSizeInfoFunctionsHooks', 'imageHeight' ) );
		return true;
	}

	static public function imageWidth( $parser, $image = '' ) {
		try {
			$title = Title::newFromText($image,NS_IMAGE);
			$file = function_exists( 'wfFindFile' ) ? wfFindFile( $title ) : new Image( $title );
			$width = (is_object( $file ) && $file->exists()) ? $file->getWidth() : 0;
			return $width;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	static public function imageHeight( $parser, $image = '' ) {
		try {
			$title = Title::newFromText($image,NS_IMAGE);
			$file = function_exists( 'wfFindFile' ) ? wfFindFile( $title ) : new Image( $title );
			$height = (is_object( $file ) && $file->exists()) ? $file->getHeight() : 0;
			return $height;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

}
