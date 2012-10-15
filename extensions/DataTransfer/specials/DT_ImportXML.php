<?php
/**
 * Lets the user import an XML file to turn into wiki pages
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class DTImportXML extends SpecialPage {

	/**
	 * Constructor
	 */
	public function DTImportXML() {
		parent::__construct( 'ImportXML' );
	}

	function execute( $query ) {
		global $wgUser, $wgOut, $wgRequest;
		$this->setHeaders();

		if ( ! $wgUser->isAllowed( 'datatransferimport' ) ) {
			global $wgOut;
			$wgOut->permissionRequired( 'datatransferimport' );
			return;
		}

		if ( $wgRequest->getCheck( 'import_file' ) ) {
			$text = DTUtils::printImportingMessage();
			$uploadResult = ImportStreamSource::newFromUpload( "file_name" );
			// handling changed in MW 1.17
			if ( $uploadResult instanceof Status ) {
				$source = $uploadResult->value;
			} else {
				$source = $uploadResult;
			}
			$importSummary = $wgRequest->getVal( 'import_summary' );
			$forPagesThatExist = $wgRequest->getVal( 'pagesThatExist' );
			$text .= self::modifyPages( $source, $importSummary, $forPagesThatExist );
		} else {
			$formText = DTUtils::printFileSelector( 'XML' );
			$formText .= DTUtils::printExistingPagesHandling();
			$formText .= DTUtils::printImportSummaryInput( 'XML' );
			$formText .= DTUtils::printSubmitButton();
			$text = "\t" . Xml::tags( 'form',
				array(
					'enctype' => 'multipart/form-data',
					'action' => '',
					'method' => 'post'
				), $formText ) . "\n";

		}

		$wgOut->addHTML( $text );
	}

	function modifyPages( $source, $editSummary, $forPagesThatExist ) {
		$text = "";
		$xml_parser = new DTXMLParser( $source );
		$xml_parser->doParse();
		$jobs = array();
		$job_params = array();
		global $wgUser;
		$job_params['user_id'] = $wgUser->getId();
		$job_params['edit_summary'] = $editSummary;
		$job_params['for_pages_that_exist'] = $forPagesThatExist;

		foreach ( $xml_parser->mPages as $page ) {
			$title = Title::newFromText( $page->getName() );
			$job_params['text'] = $page->createText();
			$jobs[] = new DTImportJob( $title, $job_params );
		}
		Job::batchInsert( $jobs );
		global $wgLang;
		$text .= wfMsgExt( 'dt_import_success', array( 'parse' ),  $wgLang->formatNum( count( $jobs ) ), 'XML' );
		return $text;
	}
}
