<?php

/**
 * Special page to direct the user to a random page in specified category
 *
 * @ingroup SpecialPage
 */
class RandomPageInCategory extends RandomPage {
	private $category = null;

	function __construct( $name = 'RandomInCategory' ) {
		parent::__construct( $name );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest;

		$this->setHeaders();
		if( is_null( $par ) ) {
			$requestCategory = $wgRequest->getVal( 'category' );
			if ( $requestCategory ) {
				$par = $requestCategory;
			} else {
				$wgOut->addHTML( $this->getForm() );
				return;
			}
		}

		$rnd = $this;
		if( !$rnd->setCategory( $par ) ) {
			$wgOut->addHTML( $this->getForm( $par ) );
			return;
		}

		$title = $rnd->getRandomTitle();

		if( is_null( $title ) ) {
			$wgOut->addWikiText( wfMsg( 'randomincategory-nocategory', $par ) );
			$wgOut->addHTML( $this->getForm( $par ) );
			return;
		}

		$wgOut->redirect( $title->getFullUrl() );
	}

	public function getCategory ( ) {
		return $this->category;
	}

	public function setCategory ( $cat ) {
		$category = Title::makeTitleSafe( NS_CATEGORY, $cat );
		//Invalid title
		if( !$category ) {
			return false;
		}
		$this->category = $category->getDBkey();
		return true;
	}

	protected function getQueryInfo( $randstr ) {
		$query = parent::getQueryInfo( $randstr );

		$query['tables'][] = 'categorylinks';

		unset( $query['conds']['page_namespace'] );
		array_merge( $query['conds'], array( 'page_namespace != ' . NS_CATEGORY ) );

		$query['conds']['cl_to'] = $this->category;

		// FIXME: FORCE INDEX gets added in wrong place, goes after table join, should be before
		// bug 27081
		unset( $query['options']['USE INDEX'] );

		$query['join_conds'] = array(
				'categorylinks' => array(
					'JOIN', array( 'page_id=cl_from' )
				)
			);

		return $query;
	}

	public function getForm( $par = null ) {
		global $wgScript, $wgRequest;
		
		$category = $par;

		if( !$category ) {
			$category = $wgRequest->getVal( 'category' );
		}

		$f =
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ) .
				Xml::openElement( 'fieldset' ) .
					Xml::element( 'legend', array(), wfMsg( 'randomincategory' ) ) .
					Html::Hidden( 'title', $this->getTitle()->getPrefixedText() ) .
					Xml::openElement( 'p' ) .
						Xml::label( wfMsg( 'randomincategory-label' ), 'category' ) . ' ' .
						Xml::input( 'category', null, $category, array( 'id' => 'category' ) ) . ' ' .
						Xml::submitButton( wfMsg( 'randomincategory-submit' ) ) .
					Xml::closeElement( 'p' ) .
				Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' );
		return $f;
	}
}
