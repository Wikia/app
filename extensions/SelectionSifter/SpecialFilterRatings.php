<?php
/**
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

class SpecialFilterRatings extends SpecialPage {

	public function __construct() {
		parent::__construct( 'FilterRatings' );
	}

	// prototypey code 
	public function execute( $par ) {

		$out = $this->getOutput();
		$lang = $this->getLanguage();
		$request = $this->getRequest();

		if( $request->wasPosted() ) {
			$out->disable();

			$action = $request->getVal( 'action' );
			$selection_name = $request->getText( 'selection' );

			if( $action == 'addtoselection' )  {
				$success = Selection::addEntries( $selection_name, $entries );
				$sel_page = new SpecialSelection();

				$url = $sel_page->getTitle()->getLinkUrl( array( 'name' => $selection_name ) );
				$return = array(
					'status' => $success,
					'selection_url' => $url
				);
			}
			echo json_encode($return);
			return;
		}

		$fields = array(
			'Project-Name' => array(
				'type' => 'text',
				'label-message' => 'ss-project',
				'tabindex' => '1'
			),
			'Importance' => array(
				'type' => 'text',
				'label-message' => 'ss-importance',
				'tabindex' => '2'
			),
			'Quality' => array(
				'type' => 'text',
				'label-message' => 'ss-quality',
				'tabindex' => '3'
			)
		);

		$project = $request->getText( 'wpProject' );
		$importance = $request->getText( 'wpImportance' );
		$quality = $request->getText( 'wpQuality' ); 

		$filters = array_filter( array(
			'r_project' => $project,
			'r_importance' => $importance,
			'r_quality' => $quality
		) );

		$this->setHeaders();
		$this->outputHeader();
		$out->setPageTitle( $this->msg( 'ss-filter-ratings' ) );

		$form = new HTMLForm( $fields, $this->getContext() );
		$form->setMethod( 'get' );
		$form->prepareForm();

		$form->displayForm( '' );

		$pager = new RatingsPager( $this, $filters );

		if ( $pager->getNumRows() ) {
			$out->addHTML(
				$pager->getNavigationBar() .
				$pager->getBody()
			);
		} else {
			$out->addWikiMsg( 'ss-ratings-empty' );
		}

		return;
	}
}

class RatingsPager extends TablePager {
	protected $conds;
	protected $page;

	/**
	 * @param $page SpecialPage
	 * @param $conds Array
	 */
	function __construct( $page, $conds ) {
		$this->page = $page;
		$this->conds = $conds;
		$this->mDefaultDirection = true;
		parent::__construct( $page->getContext() );
	}

	function getFieldNames() {
		static $headers = null;

		if ( $headers == array() ) {
			$headers = array(
				'r_project' => 'ss-project',
				'r_article' => 'ss-article',
				'r_quality' => 'ss-quality',
				'r_importance' => 'ss-importance'
			);
			$headers = array_map( 'wfMsg', $headers );
		}

		return $headers;
	}

	function getQueryInfo() {
		return array(
			'tables' => array( 'ratings' ),
			'fields' => array(
				'r_id',
				'r_project',
				'r_namespace',
				'r_article',
				'r_quality',
				'r_importance'
			),
			'conds' => $this->conds
		);
	}

	function getIndexField() {
		return 'r_id';
	}

	function getDefaultSort() {
		return 'r_id';
	}

	function isFieldSortable( $name ) {
		return false;
	}

	function formatValue( $name, $value ) {
		$row = $this->mCurrentRow;

		switch( $name ) {
		case 'r_project':
			$project_title = Title::newFromText( $row->r_project );
			return Linker::linkKnown( $project_title, htmlspecialchars( $project_title->getText() ) );
			break;
		case 'r_quality':
			return $value;
			break;
		case 'r_importance':
			return $value;
			break;
		case 'r_article':
			$title = Title::makeTitleSafe( $row->r_namespace, $row->r_article );
			return Linker::linkKnown( $title, htmlspecialchars( $title->getText() ) );
			break;
		} 
	}
}
