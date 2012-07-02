<?php

class SpecialCommunityApplications extends SpecialPage {
	function __construct() {
		parent::__construct( 'CommunityApplications', 'view-community-applications' );
	}
	
	function execute($par) {
		global $wgUser, $wgOut;
		
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		$wgOut->setPageTitle( wfMsg( 'community-applications-title' ) );
		$wgOut->addWikiMsg( 'community-applications-intro' );
		
		$sk = $wgUser->getSkin();
		$downloadTitle = $this->getTitle('csv');
		$downloadText = wfMsgExt( 'community-applications-download', 'parseinline' );
		$downloadLink = $sk->link( $downloadTitle, $downloadText );
		$wgOut->addHTML( $downloadLink );
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$res = $dbr->select( 'community_hiring_application', '*', 1, __METHOD__ );
		
		if ( $par == 'csv' ) {
			$this->csvOutput( $res );
		} else {
			foreach( $res as $row ) {
				$this->showEntry( $row );
			}
		}
	}
	
	function csvOutput( $res ) {
		global $wgOut, $wgRequest;
		
		$ts = wfTimestampNow();
		$filename = "community_applications_$ts.csv";
		$wgOut->disable();
		wfResetOutputBuffers();
		$wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
		$wgRequest->response()->header( "Content-type: text/csv; charset=utf-8" );
		$fh = fopen( 'php://output', 'w' );
		
		$fields = null;
		
		foreach( $res as $row ) {
			$data = FormatJson::decode( $row->ch_data, true );
			$data = array( 'id' => $row->ch_id ) + $data;

			if ( ! is_array($fields) ) {
				$fields = array_keys($data);
				fputcsv( $fh, $fields );
			}
			
			$outData = array();
			foreach( $fields as $k ) {
				$outData[] = isset($data[$k]) ? $data[$k] : null;
				unset( $data[$k] );
			}
			
			foreach( $data as $k => $v ) {
				$outData[] = "$k: $v";
			}
			
			fputcsv( $fh, $outData );
		}
		
		fclose( $fh );
	}
	
	function showEntry( $row ) {
		global $wgOut;
		$wgOut->addHTML( "<hr/>" );
		$wgOut->addHTML( "<table><tbody>" );
		
		$data = FormatJson::decode( $row->ch_data, true );
		
		$header = wfMsg( 'community-applications-application-title', $row->ch_id,
				$data['family-name'], $data['given-name'] );
		$wgOut->addHTML( Xml::element( 'h2', null, $header ) );
		foreach( $data as $key => $value ) {
			$html = Xml::element( 'td', null, $key );
			$html .= Xml::element( 'td', null, $value );
			$html = Xml::tags( 'tr', null, $html ) . "\n";
			$wgOut->addHTML( $html );
		}
		
		$wgOut->addHTML( "</tbody></table>" );
	}
}

