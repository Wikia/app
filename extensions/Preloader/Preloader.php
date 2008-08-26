<?php

/**
 * Extension allows preloading of custom content into all edit forms
 * when creating an article
 *
 * Also adds a new tag <nopreload> which is used to mark sections which
 * shouldn't be preloaded, ever; has no effect on the rendering of pages
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgExtensionFunctions[] = 'efPreloader';
$wgExtensionCredits['other'][] = array(
	'name'           => 'Preloader',
	'author'         => 'Rob Church',
	'version'        => '1.1.1',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Preloader',
	'description'    => 'Provides customisable per-namespace boilerplate text for new pages',
	'descriptionmsg' => 'preloader-desc',
);
$wgExtensionMessagesFiles['Preloader'] =  dirname(__FILE__) . '/Preloader.i18n.php';

/**
 * Sources of preloaded content for each namespace
 */
$wgPreloaderSource[ NS_MAIN ] = 'Template:Preload';

function efPreloader() {
	new Preloader();
}

class Preloader {

	function Preloader() {
		$this->setHooks();
	}

	/** Hook function for the preloading */
	function mainHook( &$text, &$title ) {
		$src = $this->preloadSource( $title->getNamespace() );
		if( $src ) {
			$stx = $this->sourceText( $src );
			if( $stx )
				$text = $stx;
		}
		return true;
	}

	/** Hook function for the parser */
	function parserHook( $input, $args, &$parser ) {
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
	function preloadSource( $namespace ) {
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
	function sourceText( $page ) {
		$title = Title::newFromText( $page );
		if( $title && $title->exists() ) {
			$revision = Revision::newFromTitle( $title );
			return $this->transform( $revision->getText() );
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
	function transform( $text ) {
		return trim( preg_replace( '/<nopreload>.*<\/nopreload>/s', '', $text ) );
	}

	/** Register the hook functions with MediaWiki */
	function setHooks() {
		global $wgHooks, $wgParser;
		$wgHooks['EditFormPreloadText'][] = array( &$this, 'mainHook' );
		$wgParser->setHook( 'nopreload', array( &$this, 'parserHook' ) );
	}
}
