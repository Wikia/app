<?php
/**
 * Class for viewing MediaWiki category description pages.
 * Modelled after ImagePage.php.
 *
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for category description pages, showing pages,
 * subcategories and file that belong to the category
 */
class CategoryPage extends Article {
	# Subclasses can change this to override the viewer class.
	protected $mCategoryViewerClass = 'CategoryViewer';

	/**
	 * @param $title Title
	 * @return WikiCategoryPage
	 */
	protected function newPage( Title $title ) {
		// Overload mPage with a category-specific page
		return new WikiCategoryPage( $title );
	}

	/**
	 * Constructor from a page id
	 * @param $id Int article ID to load
	 */
	public static function newFromID( $id ) {
		$t = Title::newFromID( $id );
		# @todo FIXME: Doesn't inherit right
		return $t == null ? null : new self( $t );
		# return $t == null ? null : new static( $t ); // PHP 5.3
	}

	function view() {
		$request = $this->getContext()->getRequest();
		$diff = $request->getVal( 'diff' );
		$diffOnly = $request->getBool( 'diffonly',
			$this->getContext()->getUser()->getGlobalPreference( 'diffonly' ) );

		if ( isset( $diff ) && $diffOnly ) {
			parent::view();
			return;
		}

		if ( !Hooks::run( 'CategoryPageView', [ $this ] ) ) {
			return;
		}

		$title = $this->getTitle();
		if ( NS_CATEGORY == $title->getNamespace() ) {
			$this->openShowCategory();
		}

		parent::view();

		if ( NS_CATEGORY == $title->getNamespace() ) {
			$this->closeShowCategory();
		}
	}

	function openShowCategory() {
		# For overloading
	}

	function closeShowCategory() {
		// Use these as defaults for back compat --catrope
		$request = $this->getContext()->getRequest();

		$from = $this->getPaginationParams( $request->getVal( 'from', null ) );
		$until = $this->getPaginationParams( $request->getVal( 'until', null ) );

		$viewer = new $this->mCategoryViewerClass( $this->getContext()->getTitle(), $this->getContext(), $from, $until );
		$this->getContext()->getOutput()->addHTML( $viewer->getHTML() );
	}

	// TODO support `?from=B` hardcoded by users
	private function getPaginationParams( $rawValue ) {
		$params = [];

		if ( $rawValue === null ) {
			return $params;
		}

		$exploded = explode( '|', $rawValue );

		for ( $i = 0; $i < count( $exploded ); $i++ ) {
			if ( $i % 2 !== 0 ) {
				continue;
			}

			$type = $exploded[ $i ];
			$value = $exploded[ $i + 1 ];

			if ( empty( $value ) ) {
				continue;
			}

			$params[ $type ] = $value;
		}
		return $params;
	}
}
