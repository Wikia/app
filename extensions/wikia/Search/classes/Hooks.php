<?php
/**
 * Class definition for Wikia\Search\Hooks
 */
namespace Wikia\Search;

use Wikia\Search\Indexer;

/**
 * This class is responsible for storing MediaWiki hook logic related to search.
 * Each method must be registered as a hook in the setup file, given the appropriate global settings.
 * We have also migrated backlink logic here.
 *
 * @author relwell
 * @package Search
 */
class Hooks {
	/**
	 * Stores backlinks for each target article, listing the backlink text, and which source articles link to them
	 *
	 * @var *
	 */
	protected static $outboundLinks = [];

	/**
	 * Encapsulates MediaWiki logic
	 *
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected static $service;

	/**
	 * Sends delete request to article if it gets deleted
	 *
	 * @param \WikiPage $article
	 * @param \User $user
	 * @param integer $reason
	 * @param integer $id
	 *
	 * @return true
	 */
	public static function onArticleDeleteComplete( &$article, \User &$user, $reason, $id ) {
		if ( $this->canIndex($article->getTitle()) ) {
			return ( new Indexer )->deleteArticle( $id );
		}

		return true;
	}

	/**
	 * Reindexes the page
	 *
	 * @param \WikiPage $article
	 * @param \User $user
	 * @param string $text
	 * @param string $summary
	 * @param bool $minoredit
	 * @param bool $watchthis
	 * @param string $sectionanchor
	 * @param array $flags
	 * @param \Revision $revision
	 * @param int $status
	 * @param int $baseRevId
	 *
	 * @return true
	 */
	public static function onArticleSaveComplete(
		&$article,
		&$user,
		$text,
		$summary,
		$minoredit,
		$watchthis,
		$sectionanchor,
		&$flags,
		$revision,
		&$status,
		$baseRevId
	) {
		if ( $this->canIndex($article->getTitle()) ) {
			return ( new Indexer )->reindexBatch( [ $article->getTitle()->getArticleID() ] );
		}

		return true;
	}

	/**
	 * Reindexes page on undelete
	 *
	 * @param \Title $title
	 * @param int $create
	 *
	 * @return true
	 */
	public static function onArticleUndelete( $title, $create ) {
		if ( $this->canIndex($title) ) {
			return ( new Indexer )->reindexBatch( [ $title->getArticleID() ] );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
	public static function canIndex( $title ) {
		return !in_array($title()->getNamespace(), Indexer::$excludedNamespaces);
	}

	/**
	 * Issues a reindex event or deletes all docs, depending on whether a wiki is being closed or reopened
	 *
	 * @param  int $city_public
	 * @param  int $city_id
	 * @param  string $reason
	 *
	 * @return bool
	 */
	public static function onWikiFactoryPublicStatusChange( &$city_public, &$city_id, $reason ) {
		return ( $city_public < 1 ) ? ( new Indexer )->deleteWikiDocs( $city_id ) :
			( new Indexer )->reindexWiki( $city_id );
	}

	/**
	 * Used to configure the user preference pane settings for search.
	 * This is a registered hook function of the samme name.
	 *
	 * @param \User $user
	 * @param array $defaultPreferences
	 */
	public static function onGetPreferences( $user, &$defaultPreferences ) {
		// removes core mw search prefs
		$defunctPreferences = [
			'searchlimit',
			'contextlines',
			'contextchars',
			'disablesuggest',
			'searcheverything',
			'searchnamespaces',
		];

		foreach ( $defunctPreferences as $goAway ) {
			unset( $defaultPreferences[$goAway] );
		}

		$defaultPreferences["enableGoSearch"] = [
			'type' => 'toggle',
			'label-message' => [ 'wikiasearch2-enable-go-search' ],
			'section' => 'under-the-hood/advanced-displayv2',
		];

		$defaultPreferences["searchAllNamespaces"] = [
			'type' => 'toggle',
			'label-message' => [ 'wikiasearch2-search-all-namespaces' ],
			'section' => 'under-the-hood/advanced-displayv2',
		];

		return true;
	}

	/**
	 * WikiaMobile hook to add assets so they are minified and concatenated
	 *
	 * @see    SearchControllerTest::testOnWikiaMobileAssetsPackages
	 *
	 * @param  array $jsStaticPackages
	 * @param  array $jsExtensionPackages
	 * @param  array $scssPackages
	 *
	 * @return boolean
	 */
	public static function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages ) {
		if ( \F::app()->wg->Title->isSpecial( 'Search' ) ) {
			$jsExtensionPackages[] = 'wikiasearch_js_wikiamobile';
			$scssPackages[] = 'wikiasearch_scss_wikiamobile';
		}

		return true;
	}

	/**
	 * Uses MediaWiki LinkEnd hook to store outbound links
	 *
	 * @param * $skin
	 * @param \Title $target
	 * @param array $options
	 * @param * $text
	 * @param array $attribs
	 * @param * $ret
	 *
	 * @return boolean
	 */
	public static function onLinkEnd( $skin, \Title $target, array $options, &$text, array &$attribs, &$ret ) {
		$service = self::$service ?: new MediaWikiService;
		self::$service = $service;
		$targetId = $service->getCanonicalPageIdFromPageId( $target->getArticleID() );
		if ( $targetId !== 0 ) {
			$targetDocId = $service->getWikiId() . '_' . $targetId;
			self::$outboundLinks[] = sprintf( "%s | %s", $targetDocId, strip_tags( $text ) );
		}

		return true;
	}

	/**
	 * Returns the current parse's outbound links and reinitializes the array.
	 *
	 * @return array
	 */
	public static function popLinks() {
		$links = self::$outboundLinks;
		self::$outboundLinks = [];

		return $links;
	}

}
