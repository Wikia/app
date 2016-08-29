<?php

use Wikia\Paginator\Paginator;

class CategoryPaginationViewer extends CategoryViewer {
	/**
	 * Consts to denote three sub-sections of the category page
	 */
	const TYPE_PAGE = 'page';
	const TYPE_SUBCAT = 'subcat';
	const TYPE_FILE = 'file';

	/**
	 * @var string[] content of each of the sections (excluding header and pagination)
	 */
	private $content = [];

	/**
	 * @var int[] number of elements in each of the sections
	 */
	private $counts = [];

	/**
	 * @var int[] number of elements shown on current page in each of the sections
	 */
	private $numberShown = [];

	/**
	 * @var int page number (from ?page URL param), always at least 1
	 */
	private $page = 1;

	/**
	 * @var Paginator[] paginator object for each of the sections
	 */
	private $paginators = [];

	/**
	 * @var CategoryTree
	 */
	private $tree = null;

	/**
	 * Get the category page HTML
	 *
	 * @return string
	 */
	public function getHTML() {
		global $wgCategoryMagicGallery, $wgEnableCategoryTreeExt, $wgCategoryTreeCategoryPageOptions;

		// Image galleries
		$this->showGallery = $wgCategoryMagicGallery && !$this->getOutput()->mNoGallery;
		$this->clearCategoryState();

		// Initialize category tree
		if ( !empty( $wgEnableCategoryTreeExt ) && !$this->getRequest()->getCheck( 'notree' ) ) {
			$this->tree = new CategoryTree( $wgCategoryTreeCategoryPageOptions );
			$this->tree->setHeaders( $this->getOutput() );
		}

		$this->generateData();

		/**
		 * Hook for Answers to add their section
		 * @see answerCategoryOtherSection
		 */
		$answersSection = '';
		wfRunHooks( 'CategoryViewer::getOtherSection', [ &$this, &$answersSection ] );

		/**
		 * Hook for category galleries to add the top pages at the top
		 * @see CategoryGalleriesHelper::onCategoryPageGetCategoryTop
		 */
		$categoryGallery = '';
		wfRunHooks( 'CategoryPage::getCategoryTop', [ $this, &$categoryGallery ] );

		// Render
		$this->getOutput()->addHeadItem( 'Paginator', $this->getPaginationHeadItem() );
		$tpl = new EasyTemplate( __DIR__ . '/templates' );
		$tpl->set_vars( [
			'aswersSection' => $answersSection,
			'categoryGallery' => $categoryGallery,
			'content' => $this->content,
			'counts' => $this->counts,
			'empty' => empty( $answersSection ) && empty( $this->content ),
			'lang' => $this->getLanguage(),
			'numberShown' => $this->numberShown,
			'paginator' => $this->paginators,
			'titleEscaped' => htmlspecialchars( $this->getTitle()->getText() ),
		] );
		return $tpl->render( 'category' );
	}

	/**
	 * Generate the data for each of the default sections
	 * Save it to $this->content and $this->numberShown
	 */
	private function generateData() {
		// Get counts
		$cat = $this->getCat();
		$this->counts = [
			self::TYPE_FILE => $cat->getFileCount(),
			self::TYPE_SUBCAT => $cat->getSubcatCount(),
			self::TYPE_PAGE => $cat->getPageCount() - $cat->getFileCount() - $cat->getSubcatCount(),
		];

		// Set up pagination
		$url = $cat->getTitle()->getFullURL();
		$this->page = max( 1, $this->getRequest()->getInt( 'page', 1 ) );
		foreach ( array_keys( $this->counts ) as $type ) {
			// TODO: add the #mw-pages, #mw-category-media and #mw-subcategories fragments
			$this->paginators[$type] = new Paginator( $this->counts[$type], $this->limit, $url );
			$this->paginators[$type]->setActivePage( $this->page );
		}

		// Get pages
		$this->processSection( self::TYPE_PAGE, function ( $title, $humanSortkey, $row ) {
			/** @see answerAddCategoryPage */
			if ( wfRunHooks( 'CategoryViewer::addPage', array( &$this, &$title, &$row, $humanSortkey ) ) ) {
				$this->addPage( $title, $humanSortkey, $row->page_len, $row->page_is_redirect );
				return true;
			}
			return false;
		}, function () {
			return $this->formatList( $this->articles, $this->articles_start_char );
		} );

		// Get media
		$this->processSection( self::TYPE_FILE, function ( $title, $humanSortkey, $row ) {
			$this->addImage( $title, $humanSortkey, $row->page_len, $row->page_is_redirect );
			return true;
		}, function () {
			if ( $this->showGallery ) {
				return $this->gallery->toHTML();
			}
			return $this->formatList( $this->imgsNoGallery, $this->imgsNoGallery_start_char );
		} );

		// Get subcategories
		$this->processSection( self::TYPE_SUBCAT, function ( $title, $humanSortkey, $row ) {
			$cat = Category::newFromTitle( $title );
			if ( $this->tree ) {
				$this->children[] = $this->tree->renderNodeInfo( $title, $cat );
				$this->children_start_char[] = $this->getSubcategorySortChar( $title, $humanSortkey );
			} else {
				$this->addSubcategoryObject( $cat, $humanSortkey, $row->page_len );
			}
			return true;
		}, function () {
			return $this->formatList( $this->children, $this->children_start_char );
		} );
	}

	/**
	 * Process one section. Updates $this->numberShown with number of added items
	 * If $processRow callable returns false for a given row it's not counted.
	 * Updates $this->content with the value returned by $generateContent callable.
	 *
	 * @param string $type one of self::TYPE_*
	 * @param callable $processRow run this function for each of the rows from the DB
	 *                    the following params are passed to it: ( $title, $humanSortkey, $row )
	 * @param callable $generateContent run this function if number of rows added is non-zero.
	 *                    the returned value is saved to $this->content. No params are passed to it
	 */
	private function processSection( string $type, callable $processRow, callable $generateContent ) {
		$conds = [
			'cl_type' => $type,
			'cl_to' => $this->title->getDBkey(),
		];

		/**
		 * Hook for Wall to remove wall pages from category listing
		 * @see WallHooksHelper::onBeforeCategoryData
		 */
		wfRunHooks( 'CategoryViewer::beforeCategoryData', array( &$conds ) );

		$dbr = wfGetDB( DB_SLAVE, 'category' );
		$result = $dbr->select(
			[ 'page', 'categorylinks' ],
			[ 'page_namespace', 'page_title', 'page_len', 'page_is_redirect', 'cl_sortkey_prefix' ],
			$conds,
			__METHOD__,
			[
				'ORDER BY' => 'cl_sortkey',
				'LIMIT' => $this->limit,
				'OFFSET' => $this->limit * ( $this->paginators[$type]->getActivePage() - 1 ),
				'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ),
			],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		);

		$numberShown = 0;
		if ( $result->numRows() ) {
			while ( $row = $result->fetchObject() ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title );
				$humanSortkey = $title->getCategorySortkey( $row->cl_sortkey_prefix );
				if ( $processRow( $title, $humanSortkey, $row ) ) {
					$numberShown += 1;
				}
			}
		}
		$this->numberShown[$type] = $numberShown;

		if ( $numberShown > 0 ) {
			$this->content[$type] = $generateContent();
		}
	}

	/**
	 * Get the rel="prev/next" links to put to the head
	 * From all sections, the one with the most pages is selected to decide if there's
	 * the next page or not
	 *
	 * @return string
	 */
	private function getPaginationHeadItem() {
		$numPages = -1;
		$maxPaginator = null;
		foreach ( $this->paginators as $paginator ) {
			if ( $paginator->getPagesCount() > $numPages ) {
				$numPages = $paginator->getPagesCount();
				$maxPaginator = $paginator;
			}
		}
		if ( $maxPaginator ) {
			// TODO: make sure to link without the #mw-pages, #mw-category-media and #mw-subcategories fragments
			return $maxPaginator->getHeadItem();
		}
		return '';
	}
}
