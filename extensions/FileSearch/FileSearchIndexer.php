<?php

/**
 * Extracts and indexes search terms from recognised upload formats
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Rob Church <robchur@gmail.com>
 */
class FileSearchIndexer {

	/**
	 * Registered extractor classes
	 */
	private static $extractors = array();
	
	/**
	 * Hook callback for `FileUpload`
	 *
	 * @param Image $file
	 */
	public static function upload( $file ) {
		$title = $file->getTitle();
		$article = new Article( $title );
		# If the description page doesn't exist at this time, then we're
		# dealing with a fresh upload; in this case, the index update will
		# be done when the page is deleted. On the other hand, if it *does*
		# exist, then there won't be a search index update, so we have to
		# trigger one ourselves. Not the cleanest of methods...
		if( $title->exists() ) {
			global $wgDeferredUpdateList;
			$update = new SearchUpdate( $title->getArticleId(),
				$title->getPrefixedText(), $article->getContent() );
			array_push( $wgDeferredUpdateList, $update );
		}
	}
	
	/**
	 * Hook callback for `SearchUpdate`
	 *
	 * @param int $id
	 * @param int $namespace
	 * @param string $title
	 * @param string $text
	 */
	public static function index( $id, $namespace, $title, $text ) {
		if( $namespace == NS_IMAGE ) {
			wfDebugLog( 'filesearch', "Update called for `{$title}`" );
			$titleObj = Title::makeTitle( NS_IMAGE, $title );
			$image = Image::newFromTitle( $titleObj );
			if ( !$image->exists() ) {
				wfDebugLog( 'filesearch', "Image does not exist: $title" );
				return;
			}
			$extractor = self::getExtractor( ( $mime = $image->getMimeType() ) );
			if( $extractor instanceof Extractor ) {
				wfDebugLog( 'filesearch', 'Using extractor ' . get_class( $extractor ) );
				$ftext = $extractor->extract( $image->getImagePath() );
				if( !is_null( $ftext ) )
					$text .= $ftext;
			} else {
				wfDebugLog( 'filesearch', "No suitable extractor found for `{$mime}`" );
			}
		}
	}

	/**
	 * Get an appropriate extractor for a given MIME type,
	 * if one is available
	 *
	 * @return Extractor or null
	 */
	public static function getExtractor( $mime ) {
		self::initialise();
		return isset( self::$extractors[$mime] )
			? new self::$extractors[$mime]
			: null;
	}

	/**
	 * Register extractor classes with the autoloader and
	 * set up the internal list
	 */
	public static function initialise() {
		static $done = false;
		if( !$done ) {
			global $wgAutoloadClasses, $wgFileSearchExtractors;
			foreach( $wgFileSearchExtractors as $class => $path ) {
				$wgAutoloadClasses[$class] = $path;
				$mimes = call_user_func( array( $class, 'getMimes' ) );
				if( is_array( $mimes ) ) {
					foreach( $mimes as $mime )
						self::$extractors[$mime] = $class;					
				}
			}
			$done = true;
		}
	}

}


