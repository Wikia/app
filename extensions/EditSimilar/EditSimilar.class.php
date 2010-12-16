<?php
/*
	How this extension works:
	- upon save, the script searches for articles that are similar
	  right now, I have assumed the following criteria:
	  * articles that need attention
	  * articles similar in category to the one we edited
	  * if no similar articles were found, we're taking results straight from categories that need attention
	  * number of articles in result is limited

	IMPORTANT NOTE: This extension REQUIRES the article MediaWiki:EditSimilar-Categories to exist on your
			wiki in order to run. If this article is nonexistent, the extension will disable itself.
			Format of the article is as follows:
			* Chosen Stub Category 1
			* Chosen Stub Category 2
			etc. (separated by stars)

			insert '-' if you want to disable the extension without blanking the commanding article

*/

class EditSimilar {
	var $mBaseArticle; // the article from which we hail in our quest for similiarities, this is its title
	var $mMarkerType; // how do we mark articles that need attention? currently, by category only
	var $mAttentionMarkers; // the marker array (for now it contains categories)
	var $mMatchType; // how do we match articles as a secondary
	var $mPoolLimit; // limit up the pool of 'stubs' to choose from
	var $mBaseCategories; // extracted categories that this saved article is in
	var $mSimilarArticles; // to differentiate between really similar results or just needing attention

	// constructor
	function __construct( $article, $markertype = 'category' ) {
		global $wgEditSimilarMaxResultsPool;
		$this->mBaseArticle = $article;
		$this->mMarkerType = $markertype;
		$this->mAttentionMarkers = $this->getStubCategories();
		$this->mPoolLimit = $wgEditSimilarMaxResultsPool;
		$this->mBaseCategories = $this->getBaseCategories();
		$this->mSimilarArticles = true;
	}

	// fetch categories marked as 'stub categories'
	function getStubCategories() {
		$stub_categories = wfMsgForContent( 'EditSimilar-Categories' );
		if ( ( '&lt;EditSimilar-Categories&gt;' == $stub_categories ) || ( '' == $stub_categories ) || ( '-' == $stub_categories ) ) {
			return false;
		} else {
			$lines = preg_split( "/\*/", $stub_categories );
			$normalised_lines = array();
			array_shift( $lines );
			foreach ( $lines as $line ) {
				$normalised_lines[] = str_replace( ' ', '_', trim( $line ) );
			}
			return $normalised_lines;
		}
	}

	// this is the main function that returns articles we deem similar or worth showing
	function getSimilarArticles() {
		global $wgUser, $wgEditSimilarMaxResultsToDisplay;

		if ( empty( $this->mAttentionMarkers ) || !$this->mAttentionMarkers ) {
			return false;
		}
		$text = '';
		$articles = array();
		$x = 0;

		while ( ( count( $articles ) < $wgEditSimilarMaxResultsToDisplay ) && ( $x < count( $this->mAttentionMarkers ) ) ) {
			$articles = array_merge( $articles, $this->getResults( $this->mAttentionMarkers[$x] ) );
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

		if ( 1 == count( $articles ) ) { // in this case, array_rand returns a single element, not an array
			$rand_articles = array( 0 );
		} else {
			$rand_articles = array_rand( $articles, min( $wgEditSimilarMaxResultsToDisplay, count( $articles ) ) );
		}
		$sk = $wgUser->getSkin();
		$skinname = get_class( $sk );
		$skinname = strtolower( substr( $skinname, 4 ) );
		$real_rand_values = array();
		if ( empty( $rand_articles ) ) {
			return false;
		}

		$translated_titles = array();
		foreach ( $rand_articles as $r_key => $rand_article_key ) {
			$translated_titles[] = $articles [$rand_article_key];
		}
		$translated_titles = $this->idsToTitles( $translated_titles );

		foreach ( $translated_titles as $link_title ) {
			$article_link = $sk->makeKnownLinkObj( $link_title );
			$real_rand_values[] = $article_link;
		}

		return $real_rand_values;
	}

	// extract all categories our base article is in
	function getBaseCategories() {
		global $wgEditSimilarMaxResultsToDisplay;
		if ( empty( $this->mAttentionMarkers ) || !$this->mAttentionMarkers ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$result_array = array();
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
		while ( $x = $dbr->fetchObject( $res ) ) {
			if ( !in_array( $x->cl_to, $this->mAttentionMarkers ) ) {
				$result_array[] = $x->cl_to;
			}
		}

		if ( !empty( $result_array ) ) {
			return $result_array;
		} else {
			return false;
		}
	}

	/*
		latest addition: if we got no results at all (indicating that:
			A - the article had no categories,
			B - the article had no relevant results for its categories)

		this is to ensure we can get always (well, almost - if "marker" categories get no results, it's dead in the water anyway)
		some results
	*/
	function getAdditionalCheck() {
		$dbr = wfGetDB( DB_SLAVE );

		$fixed_names = array();
		foreach ( $this->mAttentionMarkers as $category ) {
			$fixed_names[] = $dbr->addQuotes( $category );
		}
		$stringed_names = implode( ",", $fixed_names );

		$res = $dbr->select(
			'categorylinks',
			array( 'cl_from' ),
			array( "cl_to IN ($stringed_names)" ),
			__METHOD__
		);

		$result_array = array();
		while ( $x = $dbr->fetchObject( $res ) ) {
			if ( $this->mBaseArticle != $x->cl_from ) {
				$result_array[] = $x->cl_from;
			}
		}
		$dbr->freeResult( $res );

		return $result_array;
	}

	// one function to turn result ids into titles in one query rather than multiple ones
	function idsToTitles( $id_array ) {
		global $wgContentNamespaces;
		$dbr = wfGetDB( DB_SLAVE );
		$stringed_names = implode( ",", $id_array );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array( "page_id IN ($stringed_names)" ),
			__METHOD__
		);

		$result_array = array();

		// so for now, to speed things up, just discard results from other namespaces (and subpages)
		while ( ( $x = $dbr->fetchObject( $res ) )
			&& ( in_array( $x->page_namespace, $wgContentNamespaces ) )
			&& false === strpos( $x->page_title, '/' ) ) {
			$result_array[] = Title::makeTitle( $x->page_namespace, $x->page_title );
		}

		$dbr->freeResult( $res );
		return $result_array;
	}

	// get categories from the 'stub' or 'attention needed' category
	function getResults( $marker_category ) {
		$dbr = wfGetDB( DB_SLAVE );
		$title = Title::makeTitle( NS_CATEGORY, $marker_category );
		$result_array = array();

		if ( empty( $this->mBaseCategories ) ) {
			return $result_array;
		}

		$query = "SELECT c1.cl_from
				FROM {$dbr->tableName( 'categorylinks' )} AS c1, {$dbr->tableName( 'categorylinks' )} AS c2
				WHERE c1.cl_from = c2.cl_from
				AND c1.cl_to = " . $dbr->addQuotes( $title->getDBkey() )  . "
				AND c2.cl_to IN (";

		$fixed_names = array();
		foreach ( $this->mBaseCategories as $category ) {
			$fixed_names[] = $dbr->addQuotes( $category );
		}
		$stringed_names = implode( ",", $fixed_names );
		$query .= $stringed_names . ")";

		$res = $dbr->query( $query, __METHOD__ );
		while ( $x = $dbr->fetchObject( $res ) ) {
			if ( $this->mBaseArticle != $x->cl_from ) {
				$result_array[] = $x->cl_from;
			}
		}
		$dbr->freeResult( $res );

		return $result_array;
	}

	// message box wrapper
	static public function showMessage( $text ) {
		global $wgOut, $wgUser, $wgScript, $wgScriptPath;
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/EditSimilar/EditSimilar.css' );
		if ( $wgUser->isLoggedIn() ) {
			$link = '<div class="editsimilar_dismiss">[<span class="plainlinks"><a href="' . $wgScript .  '?title=Special:Preferences#prefsection-4" id="editsimilar_preferences">' . wfMsg( 'editsimilar-link-disable' ) . '</a></span>]</div><div style="display:block">&nbsp;</div>';
		} else {
			$link = '';
		}
		$wgOut->addHTML( '<div id="editsimilar_links" class="usermessage editsimilar"><div>' . $text . '</div>' . $link .  '</div>' );
	}

	// this is for determining whether to display the message or not
	static public function checkCounter() {
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