<?php
/**
 * How this extension works:
 * - upon save, the script searches for articles that are similar
 * right now, I have assumed the following criteria:
 * ** articles that need attention
 * ** articles similar in category to the one we edited
 * ** if no similar articles were found, we're taking results straight from
 *    categories that need attention
 * ** number of articles in result is limited
 *
 * IMPORTANT NOTE: This extension REQUIRES the article
 * MediaWiki:EditSimilar-Categories to exist on your wiki in order to run.
 * If this article is nonexistent, the extension will disable itself.
 *
 * Format of the article is as follows:
 * * Chosen Stub Category 1
 * * Chosen Stub Category 2
 * etc. (separated by stars)
 *
 * Insert '-' if you want to disable the extension without blanking the
 * commanding article.
 *
 * @file
 */

class EditSimilar {
	var $mBaseArticle; // the article from which we hail in our quest for similiarities, this is its title

	/**
	 * @var String: how do we mark articles that need attention? Currently, by
	 *              category only
	 */
	var $mMarkerType;

	/**
	 * @var Array: the marker array (for now it contains categories)
	 */
	var $mAttentionMarkers;

	/**
	 * @var Integer: limit up the pool of 'stubs' to choose from, controlled
	 *               via the $wgEditSimilarMaxResultsPool global variable
	 */
	var $mPoolLimit;

	/**
	 * @var Array: array of extracted categories that this saved article is in
	 */
	var $mBaseCategories;

	/**
	 * @var Boolean: to differentiate between really similar results or just
	 *               needing attention
	 */
	var $mSimilarArticles;

	/**
	 * Constructor
	 *
	 * @param $article Integer: article ID number
	 * @param $markerType String: always 'category'
	 */
	public function __construct( $article, $markerType = 'category' ) {
		global $wgEditSimilarMaxResultsPool;
		$this->mBaseArticle = $article;
		$this->mMarkerType = $markerType;
		$this->mAttentionMarkers = $this->getStubCategories();
		$this->mPoolLimit = $wgEditSimilarMaxResultsPool;
		$this->mBaseCategories = $this->getBaseCategories();
		$this->mSimilarArticles = true;
	}

	/**
	 * Fetch categories marked as 'stub categories', controlled via the
	 * MediaWiki:EditSimilar-Categories interface message.
	 *
	 * @return Array|Boolean: array of category names on success, false on
	 *                        failure (if MediaWiki:EditSimilar-Categories is
	 *                        empty or contains -)
	 */
	function getStubCategories() {
		$stubCategories = wfMsgForContent( 'EditSimilar-Categories' );
		if (
			( '&lt;EditSimilar-Categories&gt;' == $stubCategories ) ||
			( '' == $stubCategories ) || ( '-' == $stubCategories )
		)
		{
			return false;
		} else {
			$lines = preg_split( '/\*/', $stubCategories );
			$normalisedLines = array();
			array_shift( $lines );
			foreach ( $lines as $line ) {
				$normalisedLines[] = str_replace( ' ', '_', trim( $line ) );
			}
			return $normalisedLines;
		}
	}

	/**
	 * Main function that returns articles we deem similar or worth showing
	 *
	 * @return Array|Boolean: array of article names on success, false on
	 *                        failure
	 */
	function getSimilarArticles() {
		global $wgUser, $wgEditSimilarMaxResultsToDisplay;

		if ( empty( $this->mAttentionMarkers ) || !$this->mAttentionMarkers ) {
			return false;
		}
		$text = '';
		$articles = array();
		$x = 0;

		while (
			( count( $articles ) < $wgEditSimilarMaxResultsToDisplay ) &&
			( $x < count( $this->mAttentionMarkers ) )
		)
		{
			$articles = array_merge(
				$articles,
				$this->getResults( $this->mAttentionMarkers[$x] )
			);
			if ( !empty( $articles ) ) {
				$articles = array_unique( $articles );
			}
			$x++;
		}

		if ( empty( $articles ) ) {
			$articles = $this->getAdditionalCheck();
			// second check to make sure we have anything to display
			if ( empty( $articles ) ) {
				return false;
			}
			$articles = array_unique( $articles );
			$this->mSimilarArticles = false;
		}

		if ( count( $articles ) == 1 ) { // in this case, array_rand returns a single element, not an array
			$rand_articles = array( 0 );
		} else {
			$rand_articles = array_rand(
				$articles,
				min( $wgEditSimilarMaxResultsToDisplay, count( $articles ) )
			);
		}

		$sk = $wgUser->getSkin();
		$realRandValues = array();

		if ( empty( $rand_articles ) ) {
			return false;
		}

		$translatedTitles = array();
		foreach ( $rand_articles as $r_key => $rand_article_key ) {
			$translatedTitles[] = $articles[$rand_article_key];
		}
		$translatedTitles = $this->idsToTitles( $translatedTitles );

		foreach ( $translatedTitles as $linkTitle ) {
			$articleLink = $sk->makeKnownLinkObj( $linkTitle );
			$realRandValues[] = $articleLink;
		}

		return $realRandValues;
	}

	/**
	 * Extract all categories our base article is in
	 *
	 * @return Array|Boolean: array of category names on success, false on
	 *                        failure
	 */
	function getBaseCategories() {
		global $wgEditSimilarMaxResultsToDisplay;

		if ( empty( $this->mAttentionMarkers ) || !$this->mAttentionMarkers ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$resultArray = array();
		$res = $dbr->select(
			array( 'categorylinks' ),
			array( 'cl_to' ),
			array( 'cl_from' => $this->mBaseArticle ),
			__METHOD__,
			array(
				'ORDER_BY'  => 'cl_from',
				'USE_INDEX' => 'cl_from'
			)
		);

		foreach( $res as $x ) {
			if ( !in_array( $x->cl_to, $this->mAttentionMarkers ) ) {
				$resultArray[] = $x->cl_to;
			}
		}

		if ( !empty( $resultArray ) ) {
			return $resultArray;
		} else {
			return false;
		}
	}

	/**
	 * Latest addition: if we got no results at all (indicating that:
	 * A - the article had no categories,
	 * B - the article had no relevant results for its categories)
	 *
	 * This is to ensure we can get always (well, almost - if "marker"
	 * categories get no results, it's dead in the water anyway) some results.
	 *
	 * @return Array: array of category names
	 */
	function getAdditionalCheck() {
		$dbr = wfGetDB( DB_SLAVE );

		$fixedNames = array();
		foreach ( $this->mAttentionMarkers as $category ) {
			$fixedNames[] = $dbr->addQuotes( $category );
		}
		$stringedNames = implode( ',', $fixedNames );

		$res = $dbr->select(
			'categorylinks',
			array( 'cl_from' ),
			array( "cl_to IN ($stringedNames)" ),
			__METHOD__
		);

		$resultArray = array();
		foreach( $res as $x ) {
			if ( $this->mBaseArticle != $x->cl_from ) {
				$resultArray[] = $x->cl_from;
			}
		}

		return $resultArray;
	}

	/**
	 * Turn result IDs into Title objects in one query rather than multiple
	 * ones.
	 *
	 * @param $idArray Array: array of page ID numbers
	 * @return Array: array of Title objects
	 */
	function idsToTitles( $idArray ) {
		global $wgContentNamespaces;

		$dbr = wfGetDB( DB_SLAVE );
		$stringedNames = implode( ',', $idArray );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array( "page_id IN ($stringedNames)" ),
			__METHOD__
		);

		$resultArray = array();

		// so for now, to speed things up, just discard results from other namespaces (and subpages)
		while (
			( $x = $dbr->fetchObject( $res ) ) &&
			( in_array( $x->page_namespace, $wgContentNamespaces ) ) &&
			strpos( $x->page_title, '/' ) === false
		)
		{
			$resultArray[] = Title::makeTitle(
				$x->page_namespace,
				$x->page_title
			);
		}

		$dbr->freeResult( $res );
		return $resultArray;
	}

	/**
	 * Get categories from the 'stub' or 'attention needed' category
	 *
	 * @param $markerCategory String: category name
	 * @return Array: array of category names
	 */
	function getResults( $markerCategory ) {
		$dbr = wfGetDB( DB_SLAVE );
		$title = Title::makeTitle( NS_CATEGORY, $markerCategory );
		$resultArray = array();

		if ( empty( $this->mBaseCategories ) ) {
			return $resultArray;
		}

		// @todo CHECKME: is it possible to make this query use MediaWiki's
		// Database functions? If so, rewrite it!
		$query = "SELECT c1.cl_from
				FROM {$dbr->tableName( 'categorylinks' )} AS c1, {$dbr->tableName( 'categorylinks' )} AS c2
				WHERE c1.cl_from = c2.cl_from
				AND c1.cl_to = " . $dbr->addQuotes( $title->getDBkey() )  . "
				AND c2.cl_to IN (";

		$fixedNames = array();
		foreach ( $this->mBaseCategories as $category ) {
			$fixedNames[] = $dbr->addQuotes( $category );
		}
		$stringed_names = implode( ',', $fixedNames );
		$query .= $stringed_names . ')';

		$res = $dbr->query( $query, __METHOD__ );
		foreach( $res as $x ) {
			if ( $this->mBaseArticle != $x->cl_from ) {
				$resultArray[] = $x->cl_from;
			}
		}

		return $resultArray;
	}

	/**
	 * Message box wrapper
	 *
	 * @param $text String: message to show
	 */
	public static function showMessage( $text ) {
		global $wgOut, $wgUser, $wgScript, $wgScriptPath;

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/EditSimilar/EditSimilar.css' );

		// If the user is logged in, give them a link to their preferences in
		// case if they want to disable EditSimilar suggestions
		if ( $wgUser->isLoggedIn() ) {
			$link = '<div class="editsimilar_dismiss">[<span class="plainlinks"><a href="' .
				$wgScript . '?title=Special:Preferences#prefsection-4" id="editsimilar_preferences">' .
				wfMsg( 'editsimilar-link-disable' ) .
				'</a></span>]</div><div style="display:block">&#160;</div>';
		} else {
			$link = '';
		}
		$wgOut->addHTML(
			'<div id="editsimilar_links" class="usermessage editsimilar"><div>' .
			$text . '</div>' . $link .  '</div>'
		);
	}

	/**
	 * For determining whether to display the message or not
	 *
	 * @return Boolean: true to show the message, false to not show it
	 */
	public static function checkCounter() {
		global $wgEditSimilarCounterValue;
		if ( isset( $_SESSION['ES_counter'] ) ) {
			$_SESSION['ES_counter']--;
			if ( $_SESSION['ES_counter'] > 0 ) {
				return false;
			} else {
				$_SESSION['ES_counter'] = $wgEditSimilarCounterValue;
				return true;
			}
		} else {
			$_SESSION['ES_counter'] = $wgEditSimilarCounterValue;
			return true;
		}
	}

}