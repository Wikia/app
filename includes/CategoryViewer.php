<?php

if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

class CategoryViewer extends ContextSource {
	var $limit, $from,
		$members, $members_start_char;

	/**
	 * @var String
	 */
	var $nextPage;
	var $prevPage;

	/**
	 * @var Title
	 */
	var $title;

	/**
	 * @var Collation
	 */
	var $collation;

	/**
	 * Category object for this page
	 * @var Category
	 */
	private $cat;

	public $paginationUrls;
	private $prevPageIsTheFirstPage;

	/**
	 * Constructor
	 *
	 * @since 1.19 $context is a second, required parameter
	 * @param $title Title
	 * @param $context IContextSource
	 * @param $from String
	 */
	function __construct( $title, IContextSource $context, $from ) {
		global $wgCategoryPagingLimit;
		$this->title = $title;
		$this->setContext( $context );
		$this->from = $from;
		$this->limit = $wgCategoryPagingLimit;
		$this->cat = Category::newFromTitle( $title );
		$this->collation = Collation::singleton();
	}

	/**
	 * Format the category data list.
	 *
	 * @return string HTML output
	 */
	public function getHTML() {
		wfProfileIn( __METHOD__ );

		$this->clearCategoryState();
		$this->doCategoryQuery();

		$r = $this->getContent();

		if ( $r == '' ) {
			// If there is no category content to display, only
			// show the top part of the navigation links.
			// @todo FIXME: Cannot be completely suppressed because it
			//        is unknown if 'until' or 'from' makes this
			//        give 0 results.
			$r = $r . $this->getCategoryTop();
		} else {
			$r = $this->getCategoryTop() .
				$r .
				$this->getCategoryBottom();
		}

		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = wfMsgExt( 'category-empty', array( 'parse' ) );
		}

		$lang = $this->getLanguage();
		$langAttribs = array( 'lang' => $lang->getCode(), 'dir' => $lang->getDir() );
		# put a div around the headings which are in the user language
		$r = Html::openElement( 'div', $langAttribs ) . $r . '</div>';

		wfProfileOut( __METHOD__ );
		return $r;
	}

	function clearCategoryState() {
		$this->members = array();
		$this->members_start_char = array();
	}

	/**
	 * Add a subcategory to the internal lists, using a Category object
	 * @param $cat Category
	 * @param $sortkey
	 * @param $pageLength
	 */
	function addSubcategoryObject( Category $cat, $sortkey, $pageLength ) {
		// Subcategory; strip the 'Category' namespace from the link text.
		$title = $cat->getTitle();

		$link = Linker::link( $title, htmlspecialchars( $title->getText() ) );
		if ( $title->isRedirect() ) {
			// This didn't used to add redirect-in-category, but might
			// as well be consistent with the rest of the sections
			// on a category page.
			$link = '<span class="redirect-in-category">' . $link . '</span>';
		}
		$this->members[] = $link;

		$this->members_start_char[] =
			$this->getSubcategorySortChar( $cat->getTitle(), $sortkey );
	}

	/**
	 * Add a subcategory to the internal lists, using a title object
	 * @deprecated since 1.17 kept for compatibility, please use addSubcategoryObject instead
	 */
	function addSubcategory( Title $title, $sortkey, $pageLength ) {
		wfDeprecated( __METHOD__, '1.17' );
		$this->addSubcategoryObject( Category::newFromTitle( $title ), $sortkey, $pageLength );
	}

	/**
	* Get the character to be used for sorting subcategories.
	* If there's a link from Category:A to Category:B, the sortkey of the resulting
	* entry in the categorylinks table is Category:A, not A, which it SHOULD be.
	* Workaround: If sortkey == "Category:".$title, than use $title for sorting,
	* else use sortkey...
	*
	* @param Title $title
	* @param string $sortkey The human-readable sortkey (before transforming to icu or whatever).
	*/
	function getSubcategorySortChar( $title, $sortkey ) {
		global $wgContLang;

		if ( $title->getPrefixedText() == $sortkey ) {
			$word = $title->getDBkey();
		} else {
			$word = $sortkey;
		}

		$firstChar = $this->collation->getFirstLetter( $word );

		return $wgContLang->convert( $firstChar );
	}

	/**
	 * Add a page in the image namespace
	 * @param $title Title
	 * @param $sortkey
	 * @param $pageLength
	 * @param $isRedirect bool
	 */
	function addImage( Title $title, $sortkey, $pageLength, $isRedirect = false ) {
		global $wgContLang;

		$link = Linker::link( $title );

		if ( $isRedirect ) {
			// This seems kind of pointless given 'mw-redirect' class,
			// but keeping for back-compatibility with user css.
			$link = '<span class="redirect-in-category">' . $link . '</span>';
		}
		$this->members[] = $link;

		$this->members_start_char[] = $wgContLang->convert( $this->collation->getFirstLetter( $sortkey ) );
	}

	/**
	 * Add a miscellaneous page
	 * @param $title
	 * @param $sortkey
	 * @param $pageLength
	 * @param $isRedirect bool
	 */
	function addPage( Title $title, $sortkey, $pageLength, $isRedirect = false ) {
		global $wgContLang;

		$link = Linker::link( $title );
		if ( $isRedirect ) {
			// This seems kind of pointless given 'mw-redirect' class,
			// but keeping for back-compatiability with user css.
			$link = '<span class="redirect-in-category">' . $link . '</span>';
		}
		$this->members[] = $link;

		$this->members_start_char[] = $wgContLang->convert( $this->collation->getFirstLetter( $sortkey ) );
	}

	function doCategoryQuery() {
		$dbr = wfGetDB( DB_SLAVE, 'category' );

		$this->nextPage = null;

		# Get the sortkeys, if applicable.  Note that if
		# the collation in the database differs from the one
		# set in $wgCategoryCollation, pagination might go totally haywire.
		$extraConds = [];
		if ( $this->from !== null ) {
			$extraConds[] = 'cl_sortkey >= '
				. $dbr->addQuotes( $this->collation->getSortKey( $this->from ) );
		}

		/* Wikia change begin - @author: TomekO */
		/* Changed by MoLi (1.19 ugrade) */
		Hooks::run( 'CategoryViewer::beforeCategoryData',array( &$extraConds ) );
		/* Wikia change end */

		$res = $dbr->select(
			array( 'page', 'categorylinks', 'category' ),
			array( 'page_id', 'page_title', 'page_namespace', 'page_len',
				'page_is_redirect', 'cl_sortkey', 'cat_id', 'cat_title',
				'cat_subcats', 'cat_pages', 'cat_files',
				'cl_sortkey_prefix', 'cl_collation' ),
			array_merge( array( 'cl_to' => $this->title->getDBkey() ),  $extraConds ),
			__METHOD__,
			array(
				'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ),
				'LIMIT' => ( is_integer( $this->limit ) ) ? $this->limit + 1 : null,
				'ORDER BY' => 'cl_sortkey',
			),
			array(
				'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ),
				'category' => array( 'LEFT JOIN', 'cat_title = page_title AND page_namespace = ' . NS_CATEGORY )
			)
		);

		$count = 0;
		foreach ( $res as $row ) {
			$title = Title::newFromRow( $row );
			if ( $row->cl_collation === '' ) {
				// Hack to make sure that while updating from 1.16 schema
				// and db is inconsistent, that the sky doesn't fall.
				// See r83544. Could perhaps be removed in a couple decades...
				$humanSortkey = $row->cl_sortkey;
			} else {
				$humanSortkey = $title->getCategorySortkey( $row->cl_sortkey_prefix );
			}

			if ( ++$count > $this->limit
				/* Wikia change begin - @author: Federico "Lox" Lucignano */
				/* allow getting all the items in a category */
				&& is_integer( $this->limit )
				/* Wikia change end*/
			) {
				# We've reached the one extra which shows that there
				# are additional pages to be had. Stop here...
				$this->nextPage = $humanSortkey;
				break;
			}

			if ( $title->getNamespace() == NS_CATEGORY ) {
				$cat = Category::newFromRow( $row, $title );
				$this->addSubcategoryObject( $cat, $humanSortkey, $row->page_len );
			} elseif ( $title->getNamespace() == NS_FILE ) {
				$this->addImage( $title, $humanSortkey, $row->page_len, $row->page_is_redirect );
			} else {
				# <Wikia>
				if( Hooks::run( "CategoryViewer::addPage", array( $this, $title, &$row, $humanSortkey ) ) ) {
					$this->addPage( $title, $humanSortkey, $row->page_len, $row->page_is_redirect );
				}
				# </Wikia>
			}
		}

		$this->findPrevPage( $dbr );
	}

	private function findPrevPage( DatabaseMysqli $dbr ) {
		if ( $this->from === null ) {
			return;
		}

		$res = $dbr->select(
			[ 'page', 'categorylinks' ],
			[
				'page_id', 'page_title', 'page_namespace', 'page_len', 'page_is_redirect',
				'cl_sortkey_prefix', 'cl_collation'
			],
			[
				'cl_to' => $this->title->getDBkey(),
				'cl_sortkey < ' . $dbr->addQuotes( $this->collation->getSortKey( $this->from ) )
			],
			__METHOD__,
			[
				'USE INDEX' => [ 'categorylinks' => 'cl_sortkey' ],
				'LIMIT' => $this->limit + 1,
				'ORDER BY' => 'cl_sortkey DESC',
			],
			[
				'categorylinks'  => [ 'INNER JOIN', 'cl_from = page_id' ],
			]
		);

		$lastRow = null;
		$count = 0;
		$this->prevPageIsTheFirstPage = true;

		foreach ( $res as $row ) {
			$count++;

			if ( $count > $this->limit ) {
				$this->prevPageIsTheFirstPage = false;
				break;
			}

			$lastRow = $row;
		}

		$title = Title::newFromRow( $lastRow );
		if ( $lastRow->cl_collation === '' ) {
			// Hack to make sure that while updating from 1.16 schema
			// and db is inconsistent, that the sky doesn't fall.
			// See r83544. Could perhaps be removed in a couple decades...
			$humanSortkey = $lastRow->cl_sortkey;
		} else {
			$humanSortkey = $title->getCategorySortkey( $lastRow->cl_sortkey_prefix );
		}

		$this->prevPage = $humanSortkey;
	}

	/**
	 * @return string
	 */
	function getCategoryTop() {
		$r = '';
		/* Wikia change begin - @author: wladek */
		/* Category Galleries hook */
		Hooks::run('CategoryPage::getCategoryTop',array($this,&$r));
		/* Wikia change end */

		return $r === ''
			? $r
			: "<br style=\"clear:both;\"/>\n" . $r;
	}

	private function getContent() {
		$r = '';
		$rescnt = count( $this->members );
		$dbcnt = $this->cat->getPageCount();
		$countmsg = $this->getCountMessage( $rescnt, $dbcnt );

		if ( $rescnt > 0 ) {
			$r .= "<div>\n";
			$r .= "<h2>Members</h2>\n";
			$r .= $countmsg;
			$r .= $this->formatList( $this->members, $this->members_start_char );
			$r .= "\n</div>";
		}
		return $r;
	}

	/* <Wikia> */
	function getOtherSection() {
		$r = "";
		Hooks::run( "CategoryViewer::getOtherSection", [ $this, &$r ] );

		return $r;
	}
	/* </Wikia> */

	/**
	 * Get the paging links
	 *
	 * @return String: HTML output, possibly empty if there are no other pages
	 */
	private function getPagingLinks() {
		$links = [];

		if ( $this->prevPage !== null ) {
			$queryParams = [];

			if ( !$this->prevPageIsTheFirstPage ) {
				$queryParams['from'] = $this->prevPage;
			}

			$this->paginationUrls['prev'] = $this->title->getLocalURL( $queryParams );

			$links['prev'] = Linker::linkKnown(
				$this->title,
				'&#x1F448; Previous',
				[],
				$queryParams
			);
		}

		if ( $this->nextPage !== null ) {
			$queryParams = [ 'from' => $this->nextPage ];

			$this->paginationUrls['next'] = $this->title->getLocalURL( $queryParams );

			$links['next'] = Linker::linkKnown(
				$this->title,
				'Next &#x1F449;',
				[],
				$queryParams
			);
		}

		return join( " ", $links );
	}

	/**
	 * @return string
	 */
	function getCategoryBottom() {
		return $this->getPagingLinks();
	}

	/**
	 * Format a list of articles chunked by letter, either as a
	 * bullet list or a columnar format, depending on the length.
	 *
	 * @param $articles Array
	 * @param $articles_start_char Array
	 * @param $cutoff Int
	 * @return String
	 * @private
	 */
	function formatList( $articles, $articles_start_char, $cutoff = 6 ) {
		$list = '';
		if ( count ( $articles ) > $cutoff ) {
			$list = self::columnList( $articles, $articles_start_char );
		} elseif ( count( $articles ) > 0 ) {
			// for short lists of articles in categories.
			$list = self::shortList( $articles, $articles_start_char );
		}

		$pageLang = $this->title->getPageLanguage();
		$attribs = array( 'lang' => $pageLang->getCode(), 'dir' => $pageLang->getDir(),
			'class' => 'mw-content-'.$pageLang->getDir() );
		$list = Html::rawElement( 'div', $attribs, $list );

		return $list;
	}

	/**
	 * Format a list of articles chunked by letter in a three-column
	 * list, ordered vertically.
	 *
	 * TODO: Take the headers into account when creating columns, so they're
	 * more visually equal.
	 *
	 * More distant TODO: Scrap this and use CSS columns, whenever IE finally
	 * supports those.
	 *
	 * @param $articles Array
	 * @param $articles_start_char Array
	 * @return String
	 * @private
	 */
	static function columnList( $articles, $articles_start_char ) {
		$columns = array_combine( $articles, $articles_start_char );
		# Split into three columns
		$columns = array_chunk( $columns, ceil( count( $columns ) / 3 ), true /* preserve keys */ );

		$ret = '<table width="100%"><tr valign="top">';
		$prevchar = null;

		foreach ( $columns as $column ) {
			$ret .= '<td width="33.3%">';
			$colContents = array();

			# Kind of like array_flip() here, but we keep duplicates in an
			# array instead of dropping them.
			foreach ( $column as $article => $char ) {
				if ( !isset( $colContents[$char] ) ) {
					$colContents[$char] = array();
				}
				$colContents[$char][] = $article;
			}

			$first = true;
			foreach ( $colContents as $char => $articles ) {
				$ret .= '<h3>' . htmlspecialchars( $char );
				if ( $first && $char === $prevchar ) {
					# We're continuing a previous chunk at the top of a new
					# column, so add " cont." after the letter.
					$ret .= ' ' . wfMsgHtml( 'listingcontinuesabbrev' );
				}
				$ret .= "</h3>\n";

				$ret .= '<ul><li>';
				$ret .= implode( "</li>\n<li>", $articles );
				$ret .= '</li></ul>';

				$first = false;
				$prevchar = $char;
			}

			$ret .= "</td>\n";
		}

		$ret .= '</tr></table>';
		return $ret;
	}

	/**
	 * Format a list of articles chunked by letter in a bullet list.
	 * @param $articles Array
	 * @param $articles_start_char Array
	 * @return String
	 * @private
	 */
	static function shortList( $articles, $articles_start_char ) {
		$r = '<h3>' . htmlspecialchars( $articles_start_char[0] ) . "</h3>\n";
		$r .= '<ul><li>' . $articles[0] . '</li>';
		for ( $index = 1; $index < count( $articles ); $index++ ) {
			if ( $articles_start_char[$index] != $articles_start_char[$index - 1] ) {
				$r .= "</ul><h3>" . htmlspecialchars( $articles_start_char[$index] ) . "</h3>\n<ul>";
			}

			$r .= "<li>{$articles[$index]}</li>";
		}
		$r .= '</ul>';
		return $r;
	}

	/**
	 * What to do if the category table conflicts with the number of results
	 * returned?  This function says what. Each type is considered independently
	 * of the other types.
	 *
	 * @param $rescnt Int: The number of items returned by our database query.
	 * @param $dbcnt Int: The number of items according to the category table.
	 * @return String: A message giving the number of items, to output to HTML.
	 */
	private function getCountMessage( $rescnt, $dbcnt ) {
		# There are three cases:
		#   1) The category table figure seems sane.  It might be wrong, but
		#      we can't do anything about it if we don't recalculate it on ev-
		#      ery category view.
		#   2) The category table figure isn't sane, like it's smaller than the
		#      number of actual results, *but* the number of results is less
		#      than $this->limit and there's no offset.  In this case we still
		#      know the right figure.
		#   3) We have no idea.

		if ( $dbcnt == $rescnt || ( ( $rescnt == $this->limit || $this->from !== null )
			&& $dbcnt > $rescnt ) ) {
			# Case 1: seems sane.
			$totalcnt = $dbcnt;
		} elseif ( $rescnt < $this->limit && !$this->from !== null ) {
			# Case 2: not sane, but salvageable.  Use the number of results.
			# Since there are fewer than 200, we can also take this opportunity
			# to refresh the incorrect category table entry -- which should be
			# quick due to the small number of entries.
			$totalcnt = $rescnt;

			// SUS-1782: Schedule a background task to update the bogus data
			$task = new \Wikia\Tasks\Tasks\RefreshCategoryCountsTask();
			$task->call( 'refreshCounts', $this->title->getDBkey() );
			$task->queue();
		} else {
			# Case 3: hopeless.  Don't give a total count at all.
			return null;
		}
		return 'There are ' . $totalcnt . ' members in this category.';
	}

	/**
	 * getter for private $cat variable, used in Hooks
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @public
	 *
	 * @return Category $cat
	 */
	public function getCat() {
		return $this->cat;
	}
}
