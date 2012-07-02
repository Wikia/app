<?php
 
/**
 * Updates Semantic MediaWikis properties of an article when the article is purged.
 * SMW standard behavior is to update properties only on page save (as of SMW 1.6)
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:SemanticUpdateOnPurge
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:SemanticUpdateOnPurge
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SemanticUpdateOnPurge
 *
 * @version: 0.4.1
 * @license: ISC license
 * @author:  Daniel Werner < danweetz@web.de >
 * 
 * @file SemanticUpdateOnPurge.php
 * @ingroup SemanticUpdateOnPurge
 */
 
if ( !defined( 'MEDIAWIKI' ) ) { die(); }
 
# Credits
$wgExtensionCredits[ defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other' ][] = array(
	'path'           => __FILE__,
	'name'           => 'SemanticUpdateOnPurge',
	'descriptionmsg' => 'suop-desc',
	'version'        => ExtSemanticUpdateOnPurge::VERSION,
	'author'         => '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SemanticUpdateOnPurge',
);

// language file:
$wgExtensionMessagesFiles['SemanticUpdateOnPurge'] = ExtSemanticUpdateOnPurge::getDir() . '/SemanticUpdateOnPurge.i18n.php';
 
// hooks registration:
$wgHooks[ 'ArticlePurge'    ][] = 'ExtSemanticUpdateOnPurge::onArticlePurge';
$wgHooks[ 'ParserAfterTidy' ][] = 'ExtSemanticUpdateOnPurge::onParserAfterTidy';


/**
 * Extension class with all the extension functionality
 */
class ExtSemanticUpdateOnPurge {
	
	/**
	 * Version of the RegexFun extension.
	 * 
	 * @since 0.2.1
	 * 
	 * @var string
	 */
	const VERSION = '0.4.1';
	
	/**
	 * contains Title::getPrefixedDBkey() values as keys, and 'true' as value
	 * if the titles semantics should be updated. Usually only one title, just make sure
	 * this will also work if there are some weird internal purge processing is going on
	 * or several parser processes running recursivelly
	 * 
	 * @since 0.3
	 * 
	 * @var Array
	 */
	private static $mUpdateTitles = array();
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 0.4
	 * 
	 * @return string
	 */
	public static function getDir() {		
		static $dir = null;
		
		if( $dir === null ) {
			$dir = dirname( __FILE__ );
		}
		return $dir;
	}

	public static function onArticlePurge( &$article ) {
		self::addUpdateTitle( $article->getTitle() );
		return true;
	}

	/* Note: SMW uses the hook "LinksUpdateConstructed" for this which apparently won't get
	 * called when purging the article. So we have to stick with this one here.
	 */
	public static function onParserAfterTidy( &$parser, &$text ) {
		$title = $parser->getTitle();
		// make sure this isn't some title we didn't wanted to purge in the first place:              
		if( self::hasUpdateTitle( $title ) ) {
			/* 
			 * Note: don't use SMWUpdateJob here because it would parse the whole article again and 
			 * could cause some problems with very dynamic extensions like Extension:Variables.
			 */
			$output = $parser->getOutput();
			
			// only update if the page contains semantic data:
			if( isset( $output->mSMWData ) ) {
				SMWParseData::storeData( $output, $title, true );
			}
			self::removeUpdateTitle( $title );
		}
		return true;
	}
	
	private static function addUpdateTitle( Title $title ) {
		self::$mUpdateTitles[ $title->getPrefixedDBkey() ] = true;
	}
	
	private static function removeUpdateTitle( Title $title ) {
		if( self::hasUpdateTitle( $title ) ) {
			unset( self::$mUpdateTitles[ $title->getPrefixedDBkey() ] );
			return true;
		}
		return false;
	}
	
	private static function hasUpdateTitle( Title $title ) {
		$key = $title->getPrefixedDBkey();
		return ( isset( self::$mUpdateTitles[ $key ] ) && self::$mUpdateTitles[ $key ] === true );
	}
	
}