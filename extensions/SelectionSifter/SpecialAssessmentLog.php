<?php
/**
 * @todo Document this file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 * A special page showing various logs related to the assessment extension
 */
class SpecialAssessmentLog extends SpecialPage {

	public function __construct() {
		parent::__construct( 'AssessmentLog' );
	}

	public function execute( $par ) {
		$out = $this->getOutput();
		$request = $this->getRequest();

		$this->setHeaders();
		$this->outputHeader();
		$out->setPageTitle( $this->msg( 'ss-assessment-log' ) );

	$fields = array(
		'Project' => array(
		'type' => 'text',
		'label-message' => 'ss-project',
		'tabindex' => '1'
		)
	);

	$project = $request->getText( 'wpProject' );
		
		$filters = array_filter( array(
			'l_project' => $project
		) );

		$form = new HTMLForm( $fields, $this->getContext() );
		$form->setMethod( 'get' );
		$form->prepareForm();

		$form->displayForm( '' );

		$pager = new AssessmentLogPager( $this, $filters );
		if( $pager->getNumRows() ) {
			$out->addHTML( 
			$pager->getNavigationBar() . 
			'<table>' . 
				Html::rawElement( 'tr', array(), 
					Html::element( 'td', array(), wfMessage( 'ss-action' ) ) .
					Html::element( 'td', array(), wfMessage( 'ss-old' ) ) .
					Html::element( 'td', array(), wfMessage( 'ss-new' ) ) .
					Html::element( 'td', array(), wfMessage( 'ss-article' ) ) .
					Html::element( 'td', array(), wfMessage( 'ss-project' ) ) .
					Html::element( 'td', array(), wfMessage( 'ss-timestamp' ) )
				) .
				$pager->getBody() .
				'</table>' .
				$pager->getNavigationBar()
			);
		} else {
			$out->addWikiMsg( 'ss-assessment-log-empty' );
		}
	}
}

class AssessmentLogPager extends ReverseChronologicalPager {

	function __construct( $page, $conds ) {
		$this->page = $page;
		$this->conds = $conds;
		parent::__construct( $page->getContext() );
	}
	
	function getQueryInfo() {
		return array(
			'tables' => array( 'assessment_changelog' ),
			'fields' => array(
				'l_project',
				'l_namespace',
				'l_article',
				'l_action',
				'l_timestamp',
				'l_old',
				'l_new',
				'l_revision_timestamp'
			),
			'conds' => $this->conds 
		);
	}

	function getIndexField() {
		return 'l_timestamp';
	}

	function formatRow( $row ) {
		$title = Title::makeTitleSafe( $row->l_namespace, $row->l_article );
		$project_title = Title::newFromText( $row->l_project );
		return Html::rawElement( 'tr', array(),
			Html::element( 'td', array(), $row->l_action ) .
			Html::element( 'td', array(), $row->l_old ) .
			Html::element( 'td', array(), $row->l_new ) .
			Html::rawElement( 'td', array(), 
				Linker::linkKnown( $title, htmlspecialchars( $title->getText() ) ) 
			) .
			Html::rawElement( 'td', array(), 
				Linker::linkKnown( $project_title, htmlspecialchars( $project_title->getText() ) ) 
			) .
			Html::element( 'td', array(), wfTimestamp( TS_DB, $row->l_timestamp ) )
		);
	}
}	
