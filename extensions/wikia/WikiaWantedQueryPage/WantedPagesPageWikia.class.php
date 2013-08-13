<?php

class WantedPagesPageWikia extends WantedPagesPage {

	protected $excludetitles = array();
	protected $excludeorig = '';

	public function execute( $par ) {

		global $wgRequest;

		if( $et = $wgRequest->getText( 'excludetitles' ) ) {

			$this->excludeorig = $et;
			$this->excludetitles = explode( ',', $et );
		}

		parent::execute( $par );
	}

	public function isExpensive() {
		return ( $this->excludeorig != '' ? false : true );
	}

	public function isSyndicated() {
		return true;
	}

	public function getQueryInfo() {

		// oryginal query modyfied by hook WantedPages::getQueryInfo
		$query = parent::getQueryInfo();

		// extend the query with "exclude titles" option
		$excludes = array();
		foreach ( $this->excludetitles as $title ) {
			$excludes[] = " pl_title NOT LIKE '%".trim($title)."%' ";
		}

		if ( is_array( $excludes ) && count( $excludes ) > 0 ) {

			$exclude = implode( " AND ", $excludes );
			$query['conds'][] =  " (" . $exclude . ") ";
		}

		return $query;
	}

	public function getPageHeader() {

		$self = SpecialPage::getTitleFor( $this->getName() );
		$form = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= '<table><tr><td align="right">' . Xml::label( wfMessage( 'wantedquerypage-wantedpages-excludetitles' )->plain(), 'excludetitles' ) . '</td>';
		$form .= '<td>' . Xml::input( 'excludetitles', 30, $this->excludeorig, array( 'id' => 'excludetitles' ) ) . '</td></tr>';
		$form .= '<tr><td></td><td>' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . '</td></tr></table>';
		$form .= Html::hidden( 'offset', $this->offset ) . Html::hidden( 'limit', $this->limit ) . '</form>';
		return $form;
	}

	public function linkParameters() {
		return( array( 'excludetitles' => $this->excludeorig ) );
	}
}

