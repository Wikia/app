<?php

/**
 * Extension allows preloading of custom content into all edit forms
 * when creating an article
 *
 * Also adds a new tag <nopreload> which is used to mark sections which
 * shouldn't be preloaded, ever; has no effect on the rendering of pages
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Preloader',
	'author'         => 'Rob Church',
	'version'        => '1.1.1',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Preloader',
	'descriptionmsg' => 'preloader-desc',
);
$wgExtensionMessagesFiles['Preloader'] =  dirname(__FILE__) . '/Preloader.i18n.php';

/**
 * Sources of preloaded content for each namespace
 */
$wgPreloaderSource[ NS_MAIN ] = 'Template:Preload';

$wgHooks['EditFormPreloadText'][] = 'Preloader::mainHook';
$wgHooks['ParserFirstCallInit'][] = 'Preloader::setParserHook';

class Preloader {

	public static function setParserHook( $parser ) {
		$parser->setHook( 'nopreload', array( __CLASS__, 'parserHook' ) );
		return true;
	}

	/** Hook function for the preloading */
	public static function mainHook( &$text, &$title ) {
		$src = self::preloadSource( $title->getNamespace() );
		if( $src ) {
			$stx = self::sourceText( $src );
			if( $stx )
				$text = $stx;
		}
		return true;
	}

	/** Hook function for the parser */
	public static function parserHook( $input, $args, &$parser ) {
		$output = $parser->parse( $input, $parser->getTitle(), $parser->getOptions(), false, false );
		return $output->getText();
	}

	/**
	 * Determine what page should be used as the source of preloaded text
	 * for a given namespace and return the title (in text form)
	 *
	 * @param $namespace Namespace to check for
	 * @return mixed
	 */ 
	static function preloadSource( $namespace ) {
		global $wgPreloaderSource;
		if( isset( $wgPreloaderSource[ $namespace ] ) ) {
			return $wgPreloaderSource[ $namespace ];
		} else {
			return false;
		}
	}

	/**
	 * Grab the current text of a given page if it exists
	 *
	 * @param $page Text form of the page title
	 * @return mixed
	 */
	static function sourceText( $page ) {
		$title = Title::newFromText( $page );
		if( $title && $title->exists() ) {
			$revision = Revision::newFromTitle( $title );
			return self::transform( $revision->getText() );
		} else {
			return false;
		}
	}

	/**
	 * Remove <nopreload> sections from the text and trim whitespace
	 *
	 * @param $text
	 * @return string
	 */
	static function transform( $text ) {
		return trim( preg_replace( '/<nopreload>.*<\/nopreload>/s', '', $text ) );
	}
}
