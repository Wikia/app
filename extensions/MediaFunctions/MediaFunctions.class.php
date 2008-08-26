<?php

/**
 * Parser function callbacks for the MediaFunctions extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @version 1.1
 */
class MediaFunctions {

	/**
	 * Error message constants
	 */
	const ERR_INVALID_TITLE = 'mediafunctions-invalid-title';
	const ERR_NOT_EXIST = 'mediafunctions-not-exist';

	/**
	 * Get the MIME type of a file
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @return string
	 */
	public static function mediamime( $parser, $name = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			return $file->getMimeType();
		}
		return self::error( $file, $name );
	}

	/**
	 * Get the size of a file
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @return string
	 */
	public static function mediasize( $parser, $name = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			return $parser->mOptions->getSkin()->formatSize( $file->getSize() );
		}
		return self::error( $file, $name );
	}

	/**
	 * Get the height of an image
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @return string
	 */
	public static function mediaheight( $parser, $name = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			return $file->getHeight();
		}
		return self::error( $file, $name );
	}

	/**
	 * Get the width of an image
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @return string
	 */
	public static function mediawidth( $parser, $name = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			return $file->getWidth();
		}
		return self::error( $file, $name );
	}

	/**
	 * Get the dimensions of a file
	 *
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @return string
	 */
	public static function mediadimensions( $parser, $name = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			return $file->getDimensionsString();
		}
		return self::error( $file, $name );
	}

	/**
	 * Get EXIF metadata associated with a file
	 *
	 * @param Parser $parser Calling parser
	 * @param string $name File name
	 * @param string $meta Metadata name
	 * @return string
	 */
	public static function mediaexif( $parser, $name = '', $meta = '' ) {
		if( ( $file = self::resolve( $name ) ) instanceof File ) {
			$parser->mOutput->addImage( $file->getTitle()->getDBkey() );
			if( $meta && $file->getHandler()->getMetadataType( $file ) == 'exif' ) {
				$data = unserialize( $file->getMetadata() );
				if( $data && isset( $data[$meta] ) )
					return htmlspecialchars( $data[$meta] );
			}
			return '';
		}
		return self::error( $file, $name );
	}

	/**
	 * Convert a string title into a File, returning an appropriate
	 * error message string if this is not possible
	 *
	 * The string can be with or without namespace, and might
	 * include an interwiki prefix, etc.
	 *
	 * @param string $text Title string
	 * @return mixed File or string
	 */
	private static function resolve( $text ) {
		if( $text ) {
			$title = Title::newFromText( $text );
			if( $title instanceof Title ) {
				if( $title->getNamespace() != NS_IMAGE )
					$title = Title::makeTitle( NS_IMAGE, $title->getText() );
				$file = wfFindFile( $title );
				return $file instanceof File
					? $file
					: self::ERR_NOT_EXIST;
			}
		}
		return self::ERR_INVALID_TITLE;
	}

	/**
	 * Generate an error
	 *
	 * @param string $error Error code
	 * @param string $name File name
	 * @return string
	 */
	private static function error( $error, $name ) {
		wfLoadExtensionMessages( 'MediaFunctions' );
		return htmlspecialchars( wfMsgForContent( $error, $name ) );
	}
}
